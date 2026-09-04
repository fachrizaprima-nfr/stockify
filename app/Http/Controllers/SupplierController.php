<?php

namespace App\Http\Controllers;

use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $suppliers = $this->supplierService->getAllSuppliers();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $this->supplierService->createSupplier($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $this->supplierService->updateSupplier($id, $validated);

        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->supplierService->deleteSupplier($id);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }
}