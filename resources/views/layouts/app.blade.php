<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Stok - @yield('title', 'Stok Takip Sistemi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-indigo-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wide">
                📦 Mini Stok
            </a>
            <div class="flex gap-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}"
                   class="hover:text-indigo-200 {{ request()->routeIs('dashboard') ? 'underline underline-offset-4' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('products.index') }}"
                   class="hover:text-indigo-200 {{ request()->routeIs('products.*') ? 'underline underline-offset-4' : '' }}">
                    Ürünler
                </a>
                <a href="{{ route('movements.index') }}"
                   class="hover:text-indigo-200 {{ request()->routeIs('movements.*') ? 'underline underline-offset-4' : '' }}">
                    Hareketler
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Modal Script -->
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-backdrop')) {
                e.target.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
