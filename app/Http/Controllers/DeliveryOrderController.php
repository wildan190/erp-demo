<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\Order; // Sales Order
use App\Models\Customer;
use Illuminate\Http\Request;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryOrders = DeliveryOrder::with('order.customer', 'customer')->latest()->paginate(10);
        return view('delivery_orders.index', compact('deliveryOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();
        $customers = Customer::all();
        return view('delivery_orders.create', compact('orders', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_id' => 'required|exists:customers,id',
            'delivery_number' => 'required|unique:delivery_orders,delivery_number',
            'delivery_date' => 'required|date',
            'status' => 'required|string',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        DeliveryOrder::create($request->all());

        return redirect()->route('delivery-orders.index')->with('success', 'Delivery Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryOrder $deliveryOrder)
    {
        return view('delivery_orders.show', compact('deliveryOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryOrder $deliveryOrder)
    {
        $orders = Order::all();
        $customers = Customer::all();
        return view('delivery_orders.edit', compact('deliveryOrder', 'orders', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryOrder $deliveryOrder)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'customer_id' => 'required|exists:customers,id',
            'delivery_number' => 'required|unique:delivery_orders,delivery_number,' . $deliveryOrder->id,
            'delivery_date' => 'required|date',
            'status' => 'required|string',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $deliveryOrder->update($request->all());

        return redirect()->route('delivery-orders.index')->with('success', 'Delivery Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryOrder $deliveryOrder)
    {
        $deliveryOrder->delete();
        return redirect()->route('delivery-orders.index')->with('success', 'Delivery Order deleted successfully.');
    }
}
