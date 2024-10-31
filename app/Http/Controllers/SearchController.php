<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costumer;
use App\Models\Carrier;

class SearchController extends Controller
{
    public function costumers(Request $request)
    {
        $query = $request->get('query');
        $user = auth()->user();

        $costumers = Costumer::query()
            ->when($user->role === 'sales', function ($q) use ($user) {
                return $q->where('sales_rep1', $user->username)
                    ->orWhere('sales_rep2', $user->username);
            })
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('contact_name', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        return response()->json($costumers);
    }

    public function carriers(Request $request)
    {
        $query = $request->get('query');

        $carriers = Carrier::where('name', 'LIKE', "%{$query}%")
            ->orWhere('mc', 'LIKE', "%{$query}%")
            ->orWhere('dbo', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'mc', 'dbo', 'contact_name', 'phone', 'email', 'insurance', 'notes')
            ->limit(10)
            ->get();

        return response()->json($carriers);
    }

}