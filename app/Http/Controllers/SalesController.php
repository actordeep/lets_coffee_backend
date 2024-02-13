<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SalesController;

class SalesController extends Controller
{
    public function getDaySales()
    {
        try {
            $todaySales = $this->getSalesByDate(now());

            return response()->json(['day_sales' => $todaySales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getWeekSales()
    {
        try {
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            $weekSales = $this->getSalesByDateRange($startOfWeek, $endOfWeek);

            return response()->json(['week_sales' => $weekSales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMonthSales()
    {
        try {
            $startOfMonth = now()->startOfMonth();
            $endOfMonth = now()->endOfMonth();

            $monthSales = $this->getSalesByDateRange($startOfMonth, $endOfMonth);

            return response()->json(['month_sales' => $monthSales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getYearSales()
    {
        try {
            $startOfYear = now()->startOfYear();
            $endOfYear = now()->endOfYear();

            $yearSales = $this->getSalesByDateRange($startOfYear, $endOfYear);

            return response()->json(['year_sales' => $yearSales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTotalSales()
    {
        try {
            $totalSales = Transaction::where('status', 'completed')->sum('amount');

            return response()->json(['total_sales' => $totalSales]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getSalesByDateRange($startDate, $endDate)
    {
        return Transaction::whereBetween('date_time', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');
    }

    private function getSalesByDate($date)
    {
        return Transaction::whereDate('date_time', $date)
            ->where('status', 'completed')
            ->sum('amount');
    }
}