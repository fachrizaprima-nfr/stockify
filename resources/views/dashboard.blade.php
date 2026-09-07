@extends('layouts.dashboard')

@section('sidebar')
<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard" tittle="Dashboard"/>
    <x-sidebar-menu-dashboard routeName="categories.index" tittle="Kategori"/>
    <x-sidebar-menu-dashboard routeName="suppliers.index" tittle="Supplier"/>
    <x-sidebar-menu-dashboard routeName="products.index" tittle="Produk"/>
    <x-sidebar-menu-dashboard routeName="stock-in.index" tittle="Barang Masuk"/>
    <x-sidebar-menu-dashboard routeName="stock-out.index" tittle="Barang Keluar"/>
</x-sidebar-dashboard>
@endsection

@section('navbar')
    <x-navbar-dashboard></x-navbar-dashboard>
@endsection

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Ringkasan Gudang (Dashboard)</h1>
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Monitoring metrik utama dan status persediaan barang secara real-time</p>
    </div>
</div>

<div class="p-4 space-y-6">
    <!-- Kartu KPI Ringkasan -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Produk -->
        <div class="p-5 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Produk</span>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalProducts }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Barang terdaftar di sistem</p>
        </div>

        <!-- Stok Kritis -->
        <div class="p-5 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Stok Menipis</span>
                    <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $lowStockProducts->count() }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-lg dark:bg-red-900/30 text-red-600 dark:text-red-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Perlu segera restock</p>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="p-5 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Mutasi Hari Ini</span>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $todayTransactionsCount }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Barang masuk & keluar hari ini</p>
        </div>

        <!-- Total Kategori -->
        <div class="p-5 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kategori</span>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalCategories }}</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">Kelompok jenis barang</p>
        </div>
    </div>

    <!-- Peringatan Stok Menipis & 5 Transaksi Terkini -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tabel Peringatan Stok Menipis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-500 inline-block"></span>
                    Perhatian: Stok Kritis / Menipis
                </h3>
                <a href="{{ route('stock-in.index') }}" class="text-xs font-medium text-blue-600 hover:underline dark:text-blue-400">Restock Barang →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left font-semibold text-gray-500 dark:text-gray-300">Produk</th>
                            <th class="p-3 text-center font-semibold text-gray-500 dark:text-gray-300">Min. Stok</th>
                            <th class="p-3 text-center font-semibold text-gray-500 dark:text-gray-300">Sisa Stok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($lowStockProducts as $lowProd)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="p-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $lowProd->name }}</div>
                                <div class="text-xs font-mono text-gray-400">{{ $lowProd->sku }}</div>
                            </td>
                            <td class="p-3 text-center text-gray-500 dark:text-gray-400">{{ $lowProd->minimum_stock }}</td>
                            <td class="p-3 text-center">
                                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300">
                                    {{ $lowProd->current_stock }} unit
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400">Semua stok barang dalam kondisi aman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel 5 Aktivitas Transaksi Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">5 Transaksi Terakhir</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-3 text-left font-semibold text-gray-500 dark:text-gray-300">Produk</th>
                            <th class="p-3 text-center font-semibold text-gray-500 dark:text-gray-300">Tipe</th>
                            <th class="p-3 text-center font-semibold text-gray-500 dark:text-gray-300">Jumlah</th>
                            <th class="p-3 text-right font-semibold text-gray-500 dark:text-gray-300">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($recentTransactions as $tx)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="p-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $tx->product->name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $tx->notes ?: 'Tanpa catatan' }}</div>
                            </td>
                            <td class="p-3 text-center">
                                @if ($tx->type === 'in')
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Masuk</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">Keluar</span>
                                @endif
                            </td>
                            <td class="p-3 text-center font-bold {{ $tx->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $tx->type === 'in' ? '+' : '-' }}{{ $tx->quantity }}
                            </td>
                            <td class="p-3 text-right text-xs text-gray-500 dark:text-gray-400">
                                {{ date('d M', strtotime($tx->date)) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-400">Belum ada aktivitas mutasi barang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection