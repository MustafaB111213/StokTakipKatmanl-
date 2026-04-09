<?php

namespace App\Services;

use App\Models\StockMovement;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    public function __construct(
        private StockMovementRepositoryInterface $movementRepo,
        private ProductRepositoryInterface $productRepo
    ) {}

    public function addMovement(int $productId, string $type, int $quantity, ?string $note = null): StockMovement
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Miktar sıfırdan büyük olmalıdır.');
        }

        $product = $this->productRepo->find($productId);

        if ($type === 'out' && $quantity > $product->current_stock) {
            throw new \RuntimeException(
                "Yetersiz stok! Mevcut stok: {$product->current_stock}, İstenen miktar: {$quantity}"
            );
        }

        return DB::transaction(function () use ($productId, $type, $quantity, $note, $product) {
            $movement = $this->movementRepo->create([
                'product_id' => $productId,
                'type'       => $type,
                'quantity'   => $quantity,
                'note'       => $note,
            ]);

            $newStock = $type === 'in'
                ? $product->current_stock + $quantity
                : $product->current_stock - $quantity;

            $this->productRepo->update($productId, ['current_stock' => $newStock]);

            return $movement;
        });
    }
}
