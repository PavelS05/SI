<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Costumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
   {
       $user = auth()->user();

       // Pentru admin - statistici globale
       if ($user->role === 'admin') {
           $newLoads = Load::where('status', 'new')->count();
           $dispatchedLoads = Load::where('status', 'dispatched')->count();
           $inTransitLoads = Load::where('status', 'in_transit')->count();
           $deliveredLoads = Load::where('status', 'delivered')->count();
       } else {
           // Pentru alți useri - doar loadurile lor
           $newLoads = Load::where('status', 'new')
               ->where('sales', $user->username)
               ->count();
           $dispatchedLoads = Load::where('status', 'dispatched')
               ->where('sales', $user->username)
               ->count();
           $inTransitLoads = Load::where('status', 'in_transit')
               ->where('sales', $user->username)
               ->count();
           $deliveredLoads = Load::where('status', 'delivered')
               ->where('sales', $user->username)
               ->count();
       }

       // Pentru sales și csr - doar customerii lor
       $customerCount = 0;
       if (in_array($user->role, ['sales', 'csr'])) {
           $customerCount = Costumer::where('sales_rep1', $user->username)
               ->orWhere('sales_rep2', $user->username)
               ->count();
       }

       // Monthly Trends
       $monthlyData = Load::when($user->role === 'sales', function($query) use ($user) {
               return $query->where('sales', $user->username);
           })
           ->where('created_at', '>', now()->subMonths(6))
           ->select(
               DB::raw('YEAR(created_at) as year'),
               DB::raw('MONTH(created_at) as month'),
               DB::raw('count(*) as count')
           )
           ->groupBy('year', 'month')
           ->orderBy('year')
           ->orderBy('month')
           ->get()
           ->map(function($item) {
               $date = Carbon::createFromDate($item->year, $item->month);
               return [
                   'month' => $date->format('F Y'),
                   'count' => $item->count
               ];
           });

       $labels = $monthlyData->pluck('month');
       $data = $monthlyData->pluck('count');

       // Loads recente
       $recentLoads = Load::when($user->role === 'sales', function($query) use ($user) {
               return $query->where('sales', $user->username);
           })
           ->orderBy('created_at', 'desc')
           ->take(5)
           ->get();

       return view('dashboard', compact(
           'newLoads',
           'dispatchedLoads',
           'inTransitLoads',
           'deliveredLoads',
           'customerCount',
           'labels',
           'data',
           'recentLoads'
       ));
   }
}