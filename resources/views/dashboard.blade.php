@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-indigo-100 rounded-full p-4 text-3xl">📦</div>
        <div>
            <p class="text-sm text-gray-500">Toplam Ürün</p>
            <p class="text-3xl font-bold text-indigo-700">{{ $totalProducts }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-green-100 rounded-full p-4 text-3xl">🏷️</div>
        <div>
            <p class="text-sm text-gray-500">Toplam Kategori</p>
            <p class="text-3xl font-bold text-green-700">{{ $totalCategories }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-orange-100 rounded-full p-4 text-3xl">🔄</div>
        <div>
            <p class="text-sm text-gray-500">Toplam Hareket</p>
            <p class="text-3xl font-bold text-orange-700">{{ $totalMovements }}</p>
        </div>
    </div>
</div>

<!-- Düşük Stok Uyarısı -->
@if($lowStockProducts->isNotEmpty())
    <div class="bg-red-50 border border-red-300 rounded-xl p-6 mb-8">
        <h2 class="text-lg font-bold text-red-700 mb-4">
            ⚠️ Düşük Stok Uyarısı ({{ $lowStockProducts->count() }} ürün)
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-red-600 border-b border-red-200">
                        <th class="pb-2 pr-4">SKU</th>
                        <th class="pb-2 pr-4">Ürün Adı</th>
                        <th class="pb-2 pr-4">Kategori</th>
                        <th class="pb-2">Mevcut Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                        <tr class="border-b border-red-100 last:border-0">
                            <td class="py-2 pr-4 font-mono text-gray-600">{{ $product->sku }}</td>
                            <td class="py-2 pr-4 font-medium text-gray-800">{{ $product->name }}</td>
                            <td class="py-2 pr-4 text-gray-500">{{ $product->category->name }}</td>
                            <td class="py-2">
                                <span class="inline-block px-2 py-0.5 rounded font-bold
                                    {{ $product->current_stock === 0 ? 'bg-red-200 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $product->current_stock }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="bg-green-50 border border-green-300 rounded-xl p-6 mb-8">
        <p class="text-green-700 font-medium">✅ Tüm ürünlerin stok seviyeleri yeterli (10 ve üzeri).</p>
    </div>
@endif

<!-- Hızlı Bağlantılar -->
<div class="flex gap-4">
    <a href="{{ route('products.index') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
        Ürünleri Yönet
    </a>
    <a href="{{ route('movements.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
        Tüm Hareketler
    </a>
</div>
@endsection
