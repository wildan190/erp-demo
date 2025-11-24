<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Customer;
use App\Models\Product; // Add this line
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = Quotation::with('customer', 'user')->latest()->paginate(10);
        return view('quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all(); // Add this line
        return view('quotations.create', compact('customers', 'products')); // Modify this line
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_number' => 'required|unique:quotations,quotation_number',
            'quotation_date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:quotation_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return \DB::transaction(function () use ($request) {
            $quotation = Quotation::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(), // Assuming authenticated user is the creator
                'quotation_number' => $request->quotation_number,
                'quotation_date' => $request->quotation_date,
                'valid_until' => $request->valid_until,
                'status' => $request->status,
                'notes' => $request->notes,
                'total_amount' => 0, // Will be calculated from items
            ]);

            $totalAmount = 0;
            foreach ($request->items as $itemData) {
                $itemTotal = $itemData['quantity'] * $itemData['price'];
                $quotation->items()->create([
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemTotal,
                ]);
                $totalAmount += $itemTotal;
            }

            $quotation->update(['total_amount' => $totalAmount]);

            return redirect()->route('quotations.index')->with('success', 'Quotation created successfully.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load('items.product', 'customer', 'user');
        return view('quotations.show', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        $customers = Customer::all();
        return view('quotations.edit', compact('quotation', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_number' => 'required|unique:quotations,quotation_number,' . $quotation->id,
            'quotation_date' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:quotation_date',
            'status' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $quotation->update([
            'customer_id' => $request->customer_id,
            'quotation_number' => $request->quotation_number,
            'quotation_date' => $request->quotation_date,
            'valid_until' => $request->valid_until,
            'status' => $request->status,
            'total_amount' => $request->total_amount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}
