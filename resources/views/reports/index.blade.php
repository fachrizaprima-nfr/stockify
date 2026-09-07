@extends('layouts.dashboard')

@section('sidebar')
<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="dashboard" tittle="Dashboard"/>
    <x-sidebar-menu-dashboard routeName="categories.index" tittle="Kategori"/>
    <x-sidebar-menu-dashboard routeName="suppliers.index" tittle="Supplier"/>
    <x-sidebar-menu-dashboard routeName="products.index" tittle="Produk"/>
    <x-sidebar-menu-dashboard routeName="stock-in.index" tittle="Barang Masuk"/>
    <x-sidebar-menu-dashboard routeName="stock-out.index" tittle="Barang Keluar"/>
    <x-sidebar-menu-dashboard routeName="reports.index" tittle="Laporan Mutasi"/>
</x-sidebar-dashboard>
@endsection

@section('navbar')
    <x-navbar-dashboard></x-navbar-dashboard>
@endsection

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 print:hidden">
    <div class="w-full mb-1">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Laporan Mutasi Persediaan</h1>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Rekapitulasi riwayat arus keluar-masuk barang</p>
            </div>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </button>
        </div>
    </div>
</div>

<div class="p-4 space-y-4">
    <!-- Form Filter Periode & Jenis Mutasi -->
    <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700 print:hidden">
        <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block mb-2 text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-gray-300">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label class="block mb-2 text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-gray-300">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label class="block mb-2 text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-gray-300">Jenis Transaksi</label>
                <select name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Semua Mutasi</option>
                    <option value="in" {{ $selectedType === 'in' ? 'selected' : '' }}>Barang Masuk (In)</option>
                    <option value="out" {{ $selectedType === 'out' ? 'selected' : '' }}>Barang Keluar (Out)</option>
                </select>
            </div>

            <div class="flex space-x-2">
                <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                    Filter
                </button>
                <a href="{{ route('reports.index') }}" class="w-full text-center text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan Angka Mutasi -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-semibold uppercase tracking-wider text-green-600 dark:text-green-400">Total Unit Masuk</span>
            <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">+{{ $totalIn }} unit</h3>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-semibold uppercase tracking-wider text-red-600 dark:text-red-400">Total Unit Keluar</span>
            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">-{{ $totalOut }} unit</h3>
        </div>
        <div class="p-4 bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">Arus Bersih (Netto)</span>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalIn - $totalOut }} unit</h3>
        </div>
    </div>

    <!-- Tabel Detail Mutasi -->
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300 w-14">No</th>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Tanggal</th>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">SKU</th>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Nama Produk</th>
                            <th class="p-4 text-xs font-semibold text-center text-gray-500 uppercase tracking-wider dark:text-gray-300">Tipe</th>
                            <th class="p-4 text-xs font-semibold text-center text-gray-500 uppercase tracking-wider dark:text-gray-300">Kuantitas</th>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Petugas</th>
                            <th class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($transactions as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ date('d M Y', strtotime($item->date)) }}</td>
                            <td class="p-4 text-sm font-mono text-blue-600 dark:text-blue-400">{{ $item->product->sku ?? '-' }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $item->product->name ?? '-' }}</td>
                            <td class="p-4 text-sm text-center">
                                @if ($item->type === 'in')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Masuk</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300">Keluar</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm font-bold text-center {{ $item->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item->type === 'in' ? '+' : '-' }}{{ $item->quantity }}
                            </td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $item->user->name ?? 'Admin' }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $item->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-gray-500 dark:text-gray-400">Tidak ada riwayat transaksi pada filter ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection