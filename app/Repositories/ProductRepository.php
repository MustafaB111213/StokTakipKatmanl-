<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(): Collection
    {
        return Product::with('category')->orderBy('name')->get();
    }

    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function update(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        $product->update($data);

        return $product->fresh();
    }

    public function getLowStock(int $threshold = 10): Collection
    {
        return Product::with('category')
            ->where('current_stock', '<', $threshold)
            ->orderBy('current_stock')
            ->get();
    }

    public function count(): int
    {
        return Product::count();
    }
}
