<?php

namespace App\Repositories;

use App\Models\StockTransaction;

class StockTransactionRepository
{
    public function getStockIn()
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', 'in')
            ->latest()
            ->get();
    }

    public function findById($id)
    {
        return StockTransaction::findOrFail($id);
    }

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    public function delete($id)
    {
        $transaction = $this->findById($id);
        return $transaction->delete();
    }
}