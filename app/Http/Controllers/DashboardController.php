<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Hitung transaksi hari ini
        $todayTransactionsCount = StockTransaction::whereDate('date', Carbon::today())->count();

        // Ambil semua produk dan filter yang stoknya berada di bawah atau sama dengan minimum stock
        $allProducts = Product::with(['category', 'stockTransactions'])->get();
        $lowStockProducts = $allProducts->filter(function ($product) {
            return $product->current_stock <= $product->minimum_stock;
        });

        // 5 riwayat transaksi terbaru (masuk maupun keluar)
        $recentTransactions = StockTransaction::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'todayTransactionsCount',
            'lowStockProducts',
            'recentTransactions'
        ));
    }
}