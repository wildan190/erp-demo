<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;

class SalesController extends Controller
{
    /**
     * Display a listing of the sales report.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // For a basic sales report, we can fetch all orders and invoices.
        // In a real application, you'd add filtering, pagination, and date ranges.
        $orders = Order::with('items.product')->get();
        $invoices = Invoice::with('customer')->get();

        // Basic calculation for total sales (can be refined based on business logic)
        $totalSalesOrders = $orders->sum(function($order) {
            return $order->items->sum(function($item) {
                return $item->quantity * $item->unit_price;
            });
        });

        $totalSalesInvoices = $invoices->sum('total_amount');


        return view('reports.sales', compact('orders', 'invoices', 'totalSalesOrders', 'totalSalesInvoices'));
    }
}
