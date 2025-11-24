<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Minimal KPIs — can be extended later
        $usersCount = DB::table('users')->count();
        $customersCount = DB::table('customers')->count() ?? 0;

        // Sample dashboard data (replace with real queries as needed)
        // invoices table uses `amount` column in this app; fall back if different
        $invoiceAmountColumn = null;
        if (Schema::hasTable('invoices')) {
            if (Schema::hasColumn('invoices', 'amount')) {
                $invoiceAmountColumn = 'amount';
            } elseif (Schema::hasColumn('invoices', 'total')) {
                $invoiceAmountColumn = 'total';
            }
        }

        if ($invoiceAmountColumn) {
            $todaySales = DB::table('invoices')->whereDate('created_at', now())->sum($invoiceAmountColumn);
        } else {
            $todaySales = 0;
        }
        $stockValue = DB::table('products')->sum('stock') ?? 0;
        $openOrders = DB::table('orders')->where('status', 'open')->count() ?? 0;
        $suppliers = DB::table('suppliers')->count() ?? 0;

        // Build last 12 months labels (sliding window) and real monthly sales sums
        $months = [];
        $monthlySales = [];
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        for ($i = 0; $i < 12; $i++) {
            $m = $start->copy()->addMonths($i);
            $months[] = $m->format('M Y');
            if ($invoiceAmountColumn) {
                $monthlySales[] = DB::table('invoices')
                    ->whereYear('created_at', $m->year)
                    ->whereMonth('created_at', $m->month)
                    ->sum($invoiceAmountColumn);
            } else {
                $monthlySales[] = 0;
            }
        }

        // Top products by stock (limit 6) to display a meaningful stock chart
        $topProducts = [];
        $productStock = [];
        if (Schema::hasTable('products')) {
            $top = DB::table('products')
                ->select('name','stock')
                ->orderByDesc('stock')
                ->limit(6)
                ->get();
            foreach ($top as $p) {
                $topProducts[] = $p->name;
                $productStock[] = (int) $p->stock;
            }
        }

        $categories = [];
        $categoryStock = [];

        return view('dashboard', compact(
            'usersCount','customersCount','todaySales','stockValue','openOrders','suppliers',
            'months','monthlySales','topProducts','productStock','categories','categoryStock'
        ));
    }
}
