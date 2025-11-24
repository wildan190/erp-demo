<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->paginate(15);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer',
        ]);

        $product = Product::create(array_merge($data, ['stock' => $data['stock'] ?? 0]));

        if (!empty($data['stock'])) {
            InventoryMovement::create([
                'product_id' => $product->id,
                'quantity' => (int)$data['stock'],
                'type' => 'in',
                'note' => 'Initial stock',
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created');
    }

    public function show(Product $product)
    {
        $movements = $product->movements()->orderBy('created_at','desc')->get();
        return view('products.show', compact('product','movements'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($data);

        // If manual stock adjustment submitted
        if ($request->filled('adjust_quantity') && $request->filled('adjust_type')) {
            $qty = (int)$request->input('adjust_quantity');
            $type = $request->input('adjust_type');

            if ($qty !== 0 && in_array($type, ['in','out','adjustment'])) {
                DB::transaction(function () use ($product, $qty, $type, $request) {
                    $change = $type === 'out' ? -abs($qty) : abs($qty);
                    $product->stock = max(0, $product->stock + $change);
                    $product->save();

                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'quantity' => $change,
                        'type' => $type,
                        'note' => $request->input('adjust_note'),
                    ]);
                });
            }
        }

        return redirect()->route('products.show', $product)->with('success','Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success','Product deleted');
    }

    // API endpoints
    public function apiIndex()
    {
        return response()->json(Product::all());
    }

    public function apiShow(Product $product)
    {
        return response()->json($product);
    }
}
