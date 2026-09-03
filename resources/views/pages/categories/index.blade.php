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
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Kategori Barang</h1>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Master data kategori persediaan barang</p>
            </div>
            <button type="button" data-modal-target="modal-tambah-kategori" data-modal-toggle="modal-tambah-kategori" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Kategori
            </button>
        </div>

        @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
        @endif
    </div>
</div>

<div class="p-4 flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300 w-16">No</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Nama Kategori</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Deskripsi</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300 w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($categories as $index => $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $category->name }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $category->description ?? '-' }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <button type="button" data-modal-target="modal-edit-{{ $category->id }}" data-modal-toggle="modal-edit-{{ $category->id }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
                                    Edit
                                </button>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div id="modal-edit-{{ $category->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-lg max-h-full">
                                <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t dark:border-gray-700">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                            Edit Kategori: {{ $category->name }}
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-toggle="modal-edit-{{ $category->id }}">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="p-6 space-y-5">
                                            <div>
                                                <label for="name-{{ $category->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Kategori <span class="text-red-500">*</span></label>
                                                <input type="text" name="name" id="name-{{ $category->id }}" value="{{ $category->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                            </div>
                                            <div>
                                                <label for="desc-{{ $category->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Deskripsi</label>
                                                <textarea name="description" id="desc-{{ $category->id }}" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Tuliskan keterangan detail kategori...">{{ $category->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end px-6 py-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                            <button type="button" data-modal-toggle="modal-edit-{{ $category->id }}" class="py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600">
                                                Batal
                                            </button>
                                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500 dark:text-gray-400">Belum ada data kategori yang tersimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modal-tambah-kategori" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Tambah Kategori Baru
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-toggle="modal-tambah-kategori">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: Perabot Gudang" required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Tuliskan keterangan detail kategori (opsional)..."></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end px-6 py-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <button type="button" data-modal-toggle="modal-tambah-kategori" class="py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection