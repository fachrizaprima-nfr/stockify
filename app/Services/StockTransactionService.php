<?php

namespace App\Services;

use App\Repositories\StockTransactionRepository;
use Illuminate\Support\Facades\DB;

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

    public function createStockIn(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['type'] = 'in';
            return $this->stockTransactionRepository->create($data);
        });
    }

    public function deleteTransaction($id)
    {
        return $this->stockTransactionRepository->delete($id);
    }
}