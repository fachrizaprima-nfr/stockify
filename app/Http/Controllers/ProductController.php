<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $supplierService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        SupplierService $supplierService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        $categories = method_exists($this->categoryService, 'getAllCategories') 
            ? $this->categoryService->getAllCategories() 
            : $this->categoryService->getAll();
        $suppliers = $this->supplierService->getAllSuppliers();

        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku'            => 'required|string|max:100|unique:products,sku',
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->createProduct($validated);

        return redirect()->route('products.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'sku'            => 'required|string|max:100|unique:products,sku,' . $id,
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'required|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $product = Product::find($id);
            if ($product && $product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productService->updateProduct($id, $validated);

        return redirect()->route('products.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product && $product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $this->productService->deleteProduct($id);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}