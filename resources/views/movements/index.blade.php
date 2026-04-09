@extends('layouts.app')

@section('title', 'Stok Hareketleri')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Stok Hareketleri</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
            <tr>
                <th class="px-4 py-3 text-left">Tarih</th>
                <th class="px-4 py-3 text-left">Ürün</th>
                <th class="px-4 py-3 text-left">Kategori</th>
                <th class="px-4 py-3 text-center">Tür</th>
                <th class="px-4 py-3 text-center">Miktar</th>
                <th class="px-4 py-3 text-left">Not</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($movements as $movement)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">
                        {{ $movement->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $movement->product->name }}</div>
                        <div class="text-xs text-gray-400 font-mono">{{ $movement->product->sku }}</div>
                    </td>
                    <td class="px-4 py-3 text-gray-500">
                        {{ $movement->product->category->name }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($movement->type === 'in')
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                ▲ Giriş
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                ▼ Çıkış
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="font-bold {{ $movement->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $movement->type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">
                        {{ $movement->note ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        Henüz stok hareketi bulunmamaktadır.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<p class="text-sm text-gray-400 mt-3">Toplam {{ $movements->count() }} hareket listeleniyor.</p>
@endsection
