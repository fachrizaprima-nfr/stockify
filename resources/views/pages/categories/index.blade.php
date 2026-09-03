@extends('layouts.dashboard')

@section('sidebar')
<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="categories.index" tittle="Kategori"/>
</x-sidebar-dashboard>
@endsection

@section('navbar')
    <x-navbar-dashboard></x-navbar-dashboard>
@endsection

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Kategori Barang</h1>
        </div>
        <div class="sm:flex">
            <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Master data kategori persediaan</span>
            </div>
        </div>
    </div>
</div>

<div class="p-4 flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama Kategori</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Deskripsi</th>
                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($categories as $index => $category)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="p-4 text-base font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="p-4 text-base font-semibold text-gray-900 dark:text-white">{{ $category->name }}</td>
                            <td class="p-4 text-base font-normal text-gray-500 dark:text-gray-400">{{ $category->description ?? '-' }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700">
                                    Edit
                                </button>
                                <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada data kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection