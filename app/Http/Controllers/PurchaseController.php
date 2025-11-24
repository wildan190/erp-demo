<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->orderBy('created_at','desc')->paginate(15);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('purchases.create', compact('suppliers','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'nullable|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($data, &$purchase) {
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'] ?? null,
                'user_id' => auth()->id(),
                'status' => 'received',
                'total_amount' => 0,
            ]);

            $total = 0;
            foreach ($data['items'] as $it) {
                $product = isset($it['product_id']) ? Product::find($it['product_id']) : null;
                $qty = (int)$it['quantity'];
                $price = (float)$it['price'];
                $lineTotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id ?? null,
                    'quantity' => $qty,
                    'price' => $price,
                    'total' => $lineTotal,
                ]);

                // increase stock if product exists
                if ($product) {
                    $product->stock = max(0, $product->stock + $qty);
                    $product->save();
                }

                $total += $lineTotal;
            }

            $purchase->total_amount = $total;
            $purchase->save();
        });

        return redirect()->route('purchases.index')->with('success','Purchase recorded');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('items.product','supplier');
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success','Purchase deleted');
    }
}
