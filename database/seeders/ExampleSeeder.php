<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\APBill;
use App\Models\APBillItem;
use App\Models\DeliveryOrder;
use App\Models\FollowUp;

class ExampleSeeder extends Seeder
{
    public function run(): void
    {
        // Create base data
        $products = Product::factory()->count(8)->create();
        $suppliers = Supplier::factory()->count(3)->create();
        $customers = Customer::factory()->count(5)->create();

        // Create purchases to populate stock
        foreach ($suppliers as $supplier) {
            DB::transaction(function () use ($supplier, $products) {
                $purchase = Purchase::create([
                    'supplier_id' => $supplier->id,
                    'user_id' => null,
                    'status' => 'received',
                    'total_amount' => 0,
                ]);

                $total = 0;
                // attach 3 random products
                $items = $products->random(3);
                foreach ($items as $p) {
                    $qty = rand(5, 20);
                    $price = round($p->price * (0.8 + (rand(0,30)/100)), 2);
                    $line = $qty * $price;

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $p->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'total' => $line,
                    ]);

                    // increase product stock
                    $p->stock = $p->stock + $qty;
                    $p->save();

                    $total += $line;
                }

                $purchase->total_amount = $total;
                $purchase->save();
            });
        }

        // Create orders (consume stock) and invoices
        foreach ($customers->take(4) as $customer) {
            DB::transaction(function () use ($customer, $products, &$order) {
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'user_id' => null,
                    'status' => 'confirmed',
                    'total_amount' => 0,
                ]);

                $total = 0;
                $available = $products->filter(fn($p) => $p->stock > 0);
                if ($available->isEmpty()) {
                    return;
                }

                $items = $available->random(min(3, $available->count()));
                foreach ($items as $p) {
                    $qty = min($p->stock, rand(1, 5));
                    if ($qty <= 0) continue;
                    $price = $p->price;
                    $line = $qty * $price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $p->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'total' => $line,
                    ]);

                    // reduce stock
                    $p->stock = max(0, $p->stock - $qty);
                    $p->save();

                    $total += $line;
                }

                $order->total_amount = $total;
                $order->save();

                // create invoice for order
                if ($order->total_amount > 0) {
                    Invoice::create([
                        'order_id' => $order->id,
                        'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                        'amount' => $order->total_amount,
                        'status' => 'unpaid',
                        'issued_at' => now(),
                    ]);
                }

                // create delivery order
                DeliveryOrder::create([
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                    'delivery_number' => 'DO-' . rand(100000, 999999),
                    'delivery_date' => now(),
                    'status' => 'pending',
                    'shipping_address' => $customer->address ?? 'No address provided',
                    'notes' => 'Auto-generated delivery',
                ]);
            });
        }

        // Create a couple of AP bills with items
        foreach ($suppliers->take(2) as $supplier) {
            DB::transaction(function () use ($supplier, $products) {
                $bill = APBill::create([
                    'supplier_id' => $supplier->id,
                    'bill_number' => 'APB-' . rand(100000, 999999),
                    'bill_date' => now(),
                    'due_date' => now()->addDays(30),
                    'total_amount' => 0,
                    'status' => 'unpaid',
                    'notes' => 'Auto AP bill',
                ]);

                $total = 0;
                $items = $products->random(2);
                foreach ($items as $p) {
                    $qty = rand(1, 10);
                    $unit = round($p->price * (0.9 + rand(0,20)/100), 2);
                    $line = $qty * $unit;

                    APBillItem::create([
                        'ap_bill_id' => $bill->id,
                        'product_id' => $p->id,
                        'description' => $p->name,
                        'quantity' => $qty,
                        'unit_price' => $unit,
                        'total' => $line,
                    ]);

                    $total += $line;
                }

                $bill->total_amount = $total;
                $bill->save();
            });
        }

        // Create follow-ups
        FollowUp::factory()->count(8)->create();

        $this->command->info('ExampleSeeder: created products, purchases, orders, invoices, AP bills, and follow-ups.');
    }
}
