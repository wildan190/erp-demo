<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('order')->orderBy('created_at','desc')->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.items.product');
        return view('invoices.show', compact('invoice'));
    }

    // create invoice for order
    public function storeForOrder(Request $request, Order $order)
    {
        if ($order->invoice) {
            return redirect()->back()->with('error','Invoice already exists for this order');
        }

        $invoice = null;
        DB::transaction(function () use ($order, &$invoice) {
            $invoice = Invoice::create([
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'status' => 'unpaid',
                'issued_at' => now(),
            ]);
        });

        return redirect()->route('invoices.show', $invoice)->with('success','Invoice created');
    }

    public function markPaid(Request $request, Invoice $invoice)
    {
        $invoice->status = 'paid';
        $invoice->paid_at = now();
        $invoice->save();

        // update order status
        if ($invoice->order) {
            $invoice->order->status = 'fulfilled';
            $invoice->order->save();
        }

        return redirect()->route('invoices.show', $invoice)->with('success','Invoice marked paid');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load('order.customer', 'order.items.product');
        return view('invoices.print', compact('invoice'));
    }

    // API
    public function apiIndex()
    {
        return response()->json(Invoice::with('order')->get());
    }

    public function apiShow(Invoice $invoice)
    {
        return response()->json($invoice->load('order'));
    }
}
