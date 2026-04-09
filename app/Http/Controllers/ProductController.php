<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(): View
    {
        return view('products.index', [
            'products' => $this->productService->getAllProducts(),
        ]);
    }
}
