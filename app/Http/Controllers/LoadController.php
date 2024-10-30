<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function index(Request $request)
    {
        $query = Load::query()->with(['carrierRelation', 'costumerRelation', 'salesUser', 'dispatcherUser']);

        // Implementăm căutarea globală
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('load_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('shipper_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('receiver_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('carrier', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('costumer', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filtrare după status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrare după dată
        if ($request->has('date_from')) {
            $query->where('pu_date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('pu_date', '<=', $request->date_to);
        }

        $loads = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('loads.index', compact('loads'));
    }

    public function create()
    {
        $carriers = Carrier::all();
        $costumers = Costumer::all();
        return view('loads.create', compact('carriers', 'costumers'));
    }

    public function store(Request $request)
    {
        $load = Load::create($request->all());
        return redirect()->route('loads.index')->with('success', 'Load created successfully');
    }

    public function edit(Load $load)
    {
        $carriers = Carrier::all();
        $costumers = Costumer::all();
        return view('loads.edit', compact('load', 'carriers', 'costumers'));
    }

    public function update(Request $request, Load $load)
    {
        $load->update($request->all());
        return redirect()->route('loads.index')->with('success', 'Load updated successfully');
    }

    public function destroy(Load $load)
    {
        $load->delete();
        return redirect()->route('loads.index')->with('success', 'Load deleted successfully');
    }
}