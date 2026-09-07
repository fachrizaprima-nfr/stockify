<?php

namespace App\Http\Controllers;

use App\Services\StockTransactionService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class StockOutController extends Controller
{
    protected $stockTransactionService;
    protected $productService;

    public function __construct(
        StockTransactionService $stockTransactionService,
        ProductService $productService
    ) {
        $this->stockTransactionService = $stockTransactionService;
        $this->productService = $productService;
    }

    public function index()
    {
        $transactions = $this->stockTransactionService->getStockOutTransactions();
        $products = $this->productService->getAllProducts();

        return view('stock_out.index', compact('transactions', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'date'       => 'required|date',
            'notes'      => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id() ?? 1;
        $validated['status']  = 'completed';

        try {
            $this->stockTransactionService->createStockOut($validated);
            return redirect()->route('stock-out.index')->with('success', 'Transaksi barang keluar berhasil dicatat!');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['quantity' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $this->stockTransactionService->deleteTransaction($id);

        return redirect()->route('stock-out.index')->with('success', 'Riwayat transaksi barang keluar berhasil dihapus!');
    }
}