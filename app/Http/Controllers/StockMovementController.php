<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\StockMovementRepositoryInterface;
use App\Services\StockMovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function __construct(
        private StockMovementService $movementService,
        private StockMovementRepositoryInterface $movementRepo
    ) {}

    public function index(): View
    {
        return view('movements.index', [
            'movements' => $this->movementRepo->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'type'       => 'required|in:in,out',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|string|max:255',
        ]);

        try {
            $this->movementService->addMovement(
                $request->integer('product_id'),
                $request->string('type'),
                $request->integer('quantity'),
                $request->input('note')
            );

            return back()->with('success', 'Stok hareketi başarıyla kaydedildi.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
