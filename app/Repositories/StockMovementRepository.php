<?php

namespace App\Repositories;

use App\Models\StockMovement;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StockMovementRepository implements StockMovementRepositoryInterface
{
    public function all(): Collection
    {
        return StockMovement::with('product.category')
            ->latest()
            ->get();
    }

    public function create(array $data): StockMovement
    {
        return StockMovement::create($data);
    }

    public function count(): int
    {
        return StockMovement::count();
    }
}
