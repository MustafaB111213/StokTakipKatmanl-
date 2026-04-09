<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Database\Seeder;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $productStocks = [];

        foreach ($products as $product) {
            $productStocks[$product->id] = 0;
        }

        $notes = [
            'in'  => ['Tedarikçi teslimatı', 'İade ürün girişi', 'Depo transferi', 'Toplu sipariş', 'Acil temin'],
            'out' => ['Müşteri siparişi', 'Showroom kullanımı', 'Hasar/fire', 'Mağaza transferi', 'Online sipariş'],
        ];

        $movementCount = 0;
        $productIds = $products->pluck('id')->toArray();

        // Önce her ürüne en az 1 adet "in" hareketi ekle
        foreach ($productIds as $pid) {
            $qty = rand(20, 100);
            StockMovement::create([
                'product_id'  => $pid,
                'type'        => 'in',
                'quantity'    => $qty,
                'note'        => $notes['in'][array_rand($notes['in'])],
                'created_at'  => now()->subDays(rand(20, 30)),
                'updated_at'  => now()->subDays(rand(20, 30)),
            ]);
            $productStocks[$pid] += $qty;
            $movementCount++;
        }

        // 50 harekete ulaşana kadar rastgele hareketler üret
        $targetMovements = 50;
        $attempts = 0;

        while ($movementCount < $targetMovements && $attempts < 500) {
            $attempts++;
            $pid = $productIds[array_rand($productIds)];
            $currentStock = $productStocks[$pid];

            // Stok 0'sa sadece "in" yapabiliriz
            if ($currentStock === 0) {
                $type = 'in';
            } else {
                $type = (rand(0, 1) === 0) ? 'in' : 'out';
            }

            if ($type === 'in') {
                $qty = rand(5, 50);
            } else {
                // "out" miktarı mevcut stoku aşmamalı
                $maxOut = min($currentStock, 30);
                if ($maxOut < 1) {
                    continue;
                }
                $qty = rand(1, $maxOut);
            }

            $daysAgo = rand(1, 19);
            StockMovement::create([
                'product_id'  => $pid,
                'type'        => $type,
                'quantity'    => $qty,
                'note'        => $notes[$type][array_rand($notes[$type])],
                'created_at'  => now()->subDays($daysAgo),
                'updated_at'  => now()->subDays($daysAgo),
            ]);

            if ($type === 'in') {
                $productStocks[$pid] += $qty;
            } else {
                $productStocks[$pid] -= $qty;
            }

            $movementCount++;
        }

        // Ürünlerin current_stock değerlerini hareketlerin toplamıyla güncelle
        foreach ($productStocks as $pid => $stock) {
            Product::where('id', $pid)->update(['current_stock' => $stock]);
        }
    }
}
