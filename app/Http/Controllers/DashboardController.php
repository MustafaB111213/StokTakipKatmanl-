<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\StockMovementRepositoryInterface;
use App\Services\ProductService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryRepositoryInterface $categoryRepo,
        private ProductRepositoryInterface $productRepo,
        private StockMovementRepositoryInterface $movementRepo
    ) {}

    public function index(): View
    {
        return view('dashboard', [
            'totalProducts'    => $this->productRepo->count(),
            'totalCategories'  => $this->categoryRepo->count(),
            'totalMovements'   => $this->movementRepo->count(),
            'lowStockProducts' => $this->productService->getLowStockProducts(10),
        ]);
    }
}
