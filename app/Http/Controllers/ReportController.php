<?php

namespace App\Http\Controllers;

use App\Services\StockTransactionService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $stockTransactionService;

    public function __construct(StockTransactionService $stockTransactionService)
    {
        $this->stockTransactionService = $stockTransactionService;
    }

    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $type      = $request->input('type');

        $reportData = $this->stockTransactionService->getReportData($startDate, $endDate, $type);

        return view('reports.index', array_merge($reportData, [
            'startDate'    => $startDate,
            'endDate'      => $endDate,
            'selectedType' => $type,
        ]));
    }
}