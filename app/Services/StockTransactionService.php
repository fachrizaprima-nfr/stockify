<?php

namespace App\Services;

use App\Repositories\StockTransactionRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class StockTransactionService
{
    protected $stockTransactionRepository;

    public function __construct(StockTransactionRepository $stockTransactionRepository)
    {
        $this->stockTransactionRepository = $stockTransactionRepository;
    }

    public function getStockInTransactions()
    {
        return $this->stockTransactionRepository->getStockIn();
    }

    public function getStockOutTransactions()
    {
        return $this->stockTransactionRepository->getStockOut();
    }

    public function createStockIn(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['type'] = 'in';
            return $this->stockTransactionRepository->create($data);
        });
    }

    public function createStockOut(array $data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::findOrFail($data['product_id']);

            // Validasi: Cegah stok menjadi minus
            if ($product->current_stock < $data['quantity']) {
                throw new Exception("Stok tidak mencukupi! Sisa stok untuk {$product->name} hanya tersisa {$product->current_stock}.");
            }

            $data['type'] = 'out';
            return $this->stockTransactionRepository->create($data);
        });
    }

    public function deleteTransaction($id)
    {
        return $this->stockTransactionRepository->delete($id);
    }

    public function getReportData($startDate = null, $endDate = null, $type = null)
    {
        $transactions = $this->stockTransactionRepository->getFilteredTransactions($startDate, $endDate, $type);

        $totalIn = $transactions->where('type', 'in')->sum('quantity');
        $totalOut = $transactions->where('type', 'out')->sum('quantity');

        return [
            'transactions' => $transactions,
            'totalIn'      => $totalIn,
            'totalOut'     => $totalOut,
        ];
    }
}