<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Product;

    public function update(int $id, array $data): Product;

    public function getLowStock(int $threshold = 10): Collection;

    public function count(): int;
}
