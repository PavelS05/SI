<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Carrier;
use App\Models\Costumer;
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
    try {
        $data = $request->all();
        
        // Setăm dispatcher-ul automat pentru ops
        if (auth()->user()->role === 'ops') {
            $data['dispatcher'] = auth()->user()->username;
        }
        
        $load = Load::create($data);
        return redirect()->route('loads.index')->with('success', 'Load created successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error creating load: ' . $e->getMessage());
    }
}


public function edit(Load $load)
{
    return view('loads.edit', compact('load'));
}

public function update(Request $request, Load $load)
{
    try {
        $data = $request->all();
        
        // Doar admin poate modifica sales și dispatcher
        if (auth()->user()->role !== 'admin') {
            unset($data['sales']);
            unset($data['dispatcher']);
        }
        
        // Setăm dispatcher-ul automat pentru ops
        if (auth()->user()->role === 'ops' && empty($load->dispatcher)) {
            $data['dispatcher'] = auth()->user()->username;
        }

        $load->update($data);
        return redirect()->route('loads.index')->with('success', 'Load updated successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error updating load: ' . $e->getMessage());
    }
}

    public function destroy(Load $load)
    {
        $load->delete();
        return redirect()->route('loads.index')->with('success', 'Load deleted successfully');
    }
}