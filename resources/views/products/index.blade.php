@extends('layouts.app')

@section('title', 'Ürünler')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Ürünler</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">SKU</th>
                <th class="px-4 py-3 text-left">Ürün Adı</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-center">Mevcut Stok</th>
                <th class="px-4 py-3 text-center">İşlemler</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono text-gray-500">{{ $product->sku }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $product->category->name }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                            {{ $product->current_stock === 0
                                ? 'bg-red-100 text-red-700'
                                : ($product->current_stock < 10 ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                            {{ $product->current_stock }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <!-- Stok Giriş Butonu -->
                            <button onclick="openModal('modal-in-{{ $product->id }}')"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                + Giriş
                            </button>
                            <!-- Stok Çıkış Butonu -->
                            <button onclick="openModal('modal-out-{{ $product->id }}')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                    {{ $product->current_stock === 0 ? 'disabled' : '' }}>
                                - Çıkış
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Modal: Stok Giriş -->
                <div id="modal-in-{{ $product->id }}"
                     class="modal-backdrop hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Stok Girişi</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $product->name }} <span class="font-mono">({{ $product->sku }})</span></p>
                        <p class="text-sm text-gray-600 mb-4">Mevcut Stok: <strong>{{ $product->current_stock }}</strong></p>
                        <form action="{{ route('stock-movements.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="type" value="in">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Miktar *</label>
                                <input type="number" name="quantity" min="1" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Not (isteğe bağlı)</label>
                                <input type="text" name="note" maxlength="255"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                                    Girişi Kaydet
                                </button>
                                <button type="button" onclick="closeModal('modal-in-{{ $product->id }}')"
                                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-medium transition">
                                    İptal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal: Stok Çıkış -->
                <div id="modal-out-{{ $product->id }}"
                     class="modal-backdrop hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Stok Çıkışı</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $product->name }} <span class="font-mono">({{ $product->sku }})</span></p>
                        <p class="text-sm text-gray-600 mb-4">Mevcut Stok: <strong>{{ $product->current_stock }}</strong></p>
                        <form action="{{ route('stock-movements.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="type" value="out">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Miktar * (Maks: {{ $product->current_stock }})
                                </label>
                                <input type="number" name="quantity" min="1" max="{{ $product->current_stock }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Not (isteğe bağlı)</label>
                                <input type="text" name="note" maxlength="255"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400">
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium transition">
                                    Çıkışı Kaydet
                                </button>
                                <button type="button" onclick="closeModal('modal-out-{{ $product->id }}')"
                                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg font-medium transition">
                                    İptal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
