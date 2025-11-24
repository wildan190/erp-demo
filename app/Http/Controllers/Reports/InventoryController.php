<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\InventoryMovement;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory report.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Fetch all products with their latest inventory movements
        $products = Product::with('movements')->get();

        // Calculate current stock for each product
        $products->each(function ($product) {
            $product->current_stock = $product->movements->sum('quantity_change');
        });

        // For a more detailed report, you'd add filtering, pagination, and date ranges.
        $inventoryMovements = InventoryMovement::with('product')->orderBy('created_at', 'desc')->get();

        return view('reports.inventory', compact('products', 'inventoryMovements'));
    }
}
