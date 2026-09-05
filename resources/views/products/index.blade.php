@extends('layouts.dashboard')

@section('sidebar')
<x-sidebar-dashboard>
    <x-sidebar-menu-dashboard routeName="categories.index" tittle="Kategori"/>
    <x-sidebar-menu-dashboard routeName="suppliers.index" tittle="Supplier"/>
    <x-sidebar-menu-dashboard routeName="products.index" tittle="Produk"/>
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
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Produk Barang</h1>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Master data persediaan barang gudang</p>
            </div>
            <button type="button" data-modal-target="modal-tambah-produk" data-modal-toggle="modal-tambah-produk" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Produk
            </button>
        </div>

        @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800" role="alert">
            <span class="font-medium">Periksa kembali data Anda:</span>
            <ul class="mt-1 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300 w-14">No</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">SKU</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Nama Produk</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Kategori</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Supplier</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Harga Beli</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Harga Jual</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300">Min. Stok</th>
                            <th scope="col" class="p-4 text-xs font-semibold text-left text-gray-500 uppercase tracking-wider dark:text-gray-300 w-44">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse ($products as $index => $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm font-mono text-blue-600 dark:text-blue-400">{{ $product->sku }}</td>
                            <td class="p-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $product->name }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $product->category->name ?? '-' }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $product->supplier->name ?? '-' }}</td>
                            <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="p-4 text-sm font-normal text-gray-500 dark:text-gray-400">{{ $product->minimum_stock }}</td>
                            <td class="p-4 space-x-2 whitespace-nowrap">
                                <button type="button" data-modal-target="modal-edit-{{ $product->id }}" data-modal-toggle="modal-edit-{{ $product->id }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
                                    Edit
                                </button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Produk -->
                        <div id="modal-edit-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-2xl max-h-full">
                                <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t dark:border-gray-700">
                                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                            Edit Produk: {{ $product->name }}
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-toggle="modal-edit-{{ $product->id }}">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="p-6 space-y-4">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">SKU <span class="text-red-500">*</span></label>
                                                    <input type="text" name="sku" value="{{ $product->sku }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Produk <span class="text-red-500">*</span></label>
                                                    <input type="text" name="name" value="{{ $product->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Kategori <span class="text-red-500">*</span></label>
                                                    <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Supplier <span class="text-red-500">*</span></label>
                                                    <select name="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                        @foreach ($suppliers as $sup)
                                                            <option value="{{ $sup->id }}" {{ $product->supplier_id == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Harga Beli <span class="text-red-500">*</span></label>
                                                    <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Harga Jual <span class="text-red-500">*</span></label>
                                                    <input type="number" name="selling_price" value="{{ $product->selling_price }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Min. Stok <span class="text-red-500">*</span></label>
                                                    <input type="number" name="minimum_stock" value="{{ $product->minimum_stock }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Deskripsi</label>
                                                <textarea name="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end px-6 py-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                                            <button type="button" data-modal-toggle="modal-edit-{{ $product->id }}" class="py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600">
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
                            <td colspan="9" class="p-6 text-center text-gray-500 dark:text-gray-400">Belum ada data produk barang yang tersimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div id="modal-tambah-produk" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-lg dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 rounded-t dark:border-gray-700">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Tambah Produk Baru
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-toggle="modal-tambah-produk">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="sku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">SKU / Kode Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="sku" id="sku" placeholder="Contoh: BRG-001" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Contoh: Meja Lipat Kayu" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Kategori <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Supplier <span class="text-red-500">*</span></label>
                            <select name="supplier_id" id="supplier_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="" disabled selected>Pilih Supplier</option>
                                @foreach ($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="purchase_price" id="purchase_price" placeholder="Contoh: 150000" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="selling_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="selling_price" id="selling_price" placeholder="Contoh: 200000" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="minimum_stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Min. Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="minimum_stock" id="minimum_stock" placeholder="Contoh: 5" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Keterangan spesifikasi produk (opsional)..."></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-end px-6 py-4 space-x-3 border-t border-gray-200 rounded-b dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <button type="button" data-modal-toggle="modal-tambah-produk" class="py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection