<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepo
    ) {}

    public function getAllProducts(): Collection
    {
        return $this->productRepo->all();
    }

    public function getLowStockProducts(int $threshold = 10): Collection
    {
        return $this->productRepo->getLowStock($threshold);
    }
}
