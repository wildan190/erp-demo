<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at','desc')->paginate(15);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('orders.create', compact('customers','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($data, &$order) {
            $order = Order::create([
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => auth()->id(),
                'status' => 'confirmed',
                'total_amount' => 0,
            ]);

            $total = 0;
            foreach ($data['items'] as $it) {
                $product = isset($it['product_id']) ? Product::find($it['product_id']) : null;
                $price = $product ? $product->price : 0;
                $qty = (int)$it['quantity'];
                $lineTotal = $price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id ?? null,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $lineTotal,
                ]);

                // reduce stock if product exists
                if ($product) {
                    $product->stock = max(0, $product->stock - $qty);
                    $product->save();
                }

                $total += $lineTotal;
            }

            $order->total_amount = $total;
            $order->save();
        });

        return redirect()->route('orders.show', $order)->with('success','Order created');
    }

    public function show(Order $order)
    {
        $order->load('items.product','customer');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // keep editing simple for now
        $customers = Customer::orderBy('name')->get();
        return view('orders.edit', compact('order','customers'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'required|string',
        ]);

        $order->update($data);
        return redirect()->route('orders.show', $order)->with('success','Order updated');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success','Order deleted');
    }

    // API
    public function apiIndex()
    {
        return response()->json(Order::with('items')->get());
    }

    public function apiShow(Order $order)
    {
        return response()->json($order->load('items'));
    }
}
