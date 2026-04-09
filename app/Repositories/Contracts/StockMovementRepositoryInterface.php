<?php

namespace App\Repositories\Contracts;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Collection;

interface StockMovementRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): StockMovement;

    public function count(): int;
}
