<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Customer;
use App\Models\Carrier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'sales') {
            return $this->salesDashboard($user);
        } elseif ($role === 'ops') {
            return $this->opsDashboard();
        } elseif ($role === 'csr') {
            return $this->csrDashboard();
        }

        return $this->adminDashboard();
    }

    private function salesDashboard($user)
    {
        $lastWeek = now()->subDays(7);
        $query = Load::query();
        
        if ($user) {
            $query->where('sales', $user->username);
        }

        $newLoads = (clone $query)
            ->where('status', 'New')
            ->where('created_at', '>=', $lastWeek)
            ->count();

        $dispatchedLoads = (clone $query)
            ->where('status', 'Dispatched')
            ->count();

        $inTransitLoads = (clone $query)
            ->where('status', 'In transit')
            ->count();

        $deliveredLoads = (clone $query)
            ->where('status', 'Delivered')
            ->whereMonth('del_date', now()->month)
            ->count();

        $recentLoads = (clone $query)
            ->latest()
            ->with(['customerRelation'])
            ->take(5)
            ->get();

        $monthlyData = (clone $query)
            ->where('del_date', '>', now()->subMonths(6))
            ->select(
                DB::raw('YEAR(del_date) as year'),
                DB::raw('MONTH(del_date) as month'),
                DB::raw('count(*) as count'),
                DB::raw('SUM(customer_rate - carrier_rate) as profit')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->take(5);

        return view('dashboard', compact(
            'newLoads',
            'dispatchedLoads',
            'inTransitLoads',
            'deliveredLoads',
            'recentLoads',
            'monthlyData'
        ));
    }

    private function opsDashboard()
    {
        $today = now()->format('Y-m-d');
        
        $dispatchedToday = Load::where('status', 'Dispatched')
            ->whereDate('created_at', $today)
            ->count();

        $inTransitLoads = Load::where('status', 'In transit')->count();
        
        $deliveriesToday = Load::where('del_date', $today)->count();
        
        $unassignedLoads = Load::whereNull('dispatcher')
            ->where('status', 'New')
            ->count();

        $urgentLoads = Load::where('status', 'New')
            ->whereDate('pu_date', '<=', now()->addDays(2))
            ->count();

        $recentLoads = Load::where('status', 'New')
            ->orWhere('status', 'Dispatched')
            ->with(['customerRelation', 'carrierRelation'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'dispatchedToday',
            'inTransitLoads',
            'deliveriesToday',
            'unassignedLoads',
            'urgentLoads',
            'recentLoads'
        ));
    }

    private function csrDashboard()
    {
        //active carriers are those where notes doesn't contain 'inactive'/'blacklisted'
        $activeCarriers = Carrier::where('notes', 'not like', '%inactive%')
            ->where('notes', 'not like', '%blacklisted%')
            ->count();
        $totalCarriers = Carrier::count();
        
        $activeCustomers = Customer::where('status', 'active')->count();
        $totalCustomers = Customer::count();
        
        $pendingLoads = Load::where('status', 'New')->count();
        $completedLoads = Load::where('status', 'Delivered')
            ->whereMonth('del_date', now()->month)
            ->count();

        $recentLoads = Load::with(['customerRelation', 'carrierRelation'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'activeCarriers',
            'totalCarriers',
            'activeCustomers',
            'totalCustomers',
            'pendingLoads',
            'completedLoads',
            'recentLoads'
        ));
    }

    private function adminDashboard()
    {
        // Similar to sales dashboard but without user filtering
        return $this->salesDashboard(null);
    }
}