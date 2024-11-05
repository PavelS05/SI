<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    $user = auth()->user();
    $lastWeek = now()->subDays(7);

    // Query de bază
    $baseQuery = Load::query();
    if ($user->role !== 'admin') {
        $baseQuery->where('sales', $user->username);
    }

    // Statistici - folosim clone pentru a nu afecta query-ul original
    $newLoads = (clone $baseQuery)
        ->where('status', 'new')
        ->where('created_at', '>=', $lastWeek)
        ->count();

    $dispatchedLoads = (clone $baseQuery)
        ->where('status', 'dispatched')
        ->count();

    $inTransitLoads = (clone $baseQuery)
        ->where('status', 'in_transit')
        ->count();

    $deliveredLoads = (clone $baseQuery)
        ->where('status', 'delivered')
        ->whereMonth('created_at', now()->month)
        ->count();

    // Recent Loads
    $recentLoads = (clone $baseQuery)
        ->latest()
        ->with(['customerRelation'])
        ->take(5)
        ->get();

    // Monthly trends
    $monthlyData = (clone $baseQuery)
        ->where('created_at', '>', now()->subMonths(6))
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('count(*) as count'),
            DB::raw('SUM(customer_rate - carrier_rate) as profit')
        )
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get()
        ->take(5)
        ->map(function($item) {
            $date = Carbon::createFromDate($item->year, $item->month);
            return [
                'month' => $date->format('F Y'),
                'count' => $item->count,
                'profit' => $item->profit
            ];
        });

    $monthlyData = $monthlyData->reverse()->values();
    $labels = $monthlyData->pluck('month');
    $data = $monthlyData->pluck('count');

    return view('dashboard', compact(
        'newLoads',
        'dispatchedLoads',
        'inTransitLoads',
        'deliveredLoads',
        'recentLoads',
        'labels',
        'data'
    ));
}
}