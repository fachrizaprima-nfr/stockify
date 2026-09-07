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

    public function getStockOut()
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', 'out')
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

    public function getFilteredTransactions($startDate = null, $endDate = null, $type = null)
    {
        $query = StockTransaction::with(['product', 'user']);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($type && in_array($type, ['in', 'out'])) {
            $query->where('type', $type);
        }

        return $query->latest('date')->latest('id')->get();
    }
}