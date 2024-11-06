<?php

namespace App\Http\Controllers;

use App\Models\Load;
use App\Models\Carrier;
use App\Models\Customer;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    public function index(Request $request)
    {
        $query = Load::query();

        // Doar sales vede doar load-urile proprii
        if (auth()->user()->role === 'sales') {
            $query->where('sales', auth()->user()->username);
        }

        // Căutare și filtre existente
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('load_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('customer', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('carrier', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('driver_name', 'LIKE', "%{$searchTerm}%");  // adăugat căutare după driver
            });
        }

        if ($request->status && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->where('pu_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->where('pu_date', '<=', $request->date_to);
        }

        $loads = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('loads.index', compact('loads'));
    }

    public function create()
    {
        $customers = Customer::select('id', 'name')->get();
        $carriers = Carrier::select('id', 'name')->get();

        return view('loads.create', compact('customers', 'carriers'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'sales' => 'required|string',
                'customer' => 'required|string',
                'customer_rate' => 'nullable|numeric',
                'carrier' => 'nullable|string',
                'carrier_rate' => 'nullable|numeric',
                'equipment_type' => 'nullable|string',    
                'driver_name' => 'nullable|string',       
                'driver_contact' => 'nullable|string',    
                'service' => 'nullable|string',
                'shipper_name' => 'nullable|string',
                'shipper_address' => 'nullable|string',
                'pu_date' => 'nullable|date',
                'po' => 'nullable|string',
                'pu_appt' => 'nullable|string',
                'receiver_name' => 'nullable|string',
                'receiver_address' => 'nullable|string',
                'del_date' => 'nullable|date',
                'del' => 'nullable|string',
                'del_appt' => 'nullable|string',
                'status' => 'required|string',
                'dispatcher' => 'nullable|string'
            ]);

            $load = Load::create($validatedData);

            return redirect()
                ->route('loads.index')
                ->with('success', 'Load created successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create load: ' . $e->getMessage()]);
        }
    }

    public function edit(Load $load)
    {
        // Verifică permisiunile
        if (auth()->user()->role === 'sales' && $load->sales !== auth()->user()->username) {
            return redirect()->route('loads.index')
                ->with('error', 'You are not authorized to edit this load.');
        }

        $customers = Customer::select('id', 'name')->get();
        $carriers = Carrier::select('id', 'name')->get();

        return view('loads.edit', compact('load', 'customers', 'carriers'));
    }

    public function update(Request $request, Load $load)
    {
        try {
            // Verifică permisiunile
            if (auth()->user()->role === 'sales' && $load->sales !== auth()->user()->username) {
                return redirect()->route('loads.index')
                    ->with('error', 'You are not authorized to update this load.');
            }

            $validatedData = $request->validate([
                'sales' => 'required|string',
                'customer' => 'required|string',
                'customer_rate' => 'nullable|numeric',
                'carrier' => 'nullable|string',
                'carrier_rate' => 'nullable|numeric',
                'equipment_type' => 'nullable|string',    // nou
                'driver_name' => 'nullable|string',       // nou
                'driver_contact' => 'nullable|string',    // nou
                'service' => 'required|string',
                'shipper_name' => 'nullable|string',
                'shipper_address' => 'nullable|string',
                'pu_date' => 'nullable|date',
                'po' => 'nullable|string',
                'pu_appt' => 'nullable|string',
                'receiver_name' => 'nullable|string',
                'receiver_address' => 'nullable|string',
                'del_date' => 'nullable|date',
                'del' => 'nullable|string',
                'del_appt' => 'nullable|string',
                'status' => 'required|string',
                'dispatcher' => 'nullable|string'
            ]);

            // Doar admin poate modifica sales și dispatcher
            if (auth()->user()->role !== 'admin') {
                unset($validatedData['sales']);
                unset($validatedData['dispatcher']);
            }

            // Setăm dispatcher-ul automat pentru ops
            if (auth()->user()->role === 'ops' && empty($load->dispatcher)) {
                $validatedData['dispatcher'] = auth()->user()->username;
            }

            $load->update($validatedData);

            return redirect()
                ->route('loads.index')
                ->with('success', 'Load updated successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update load: ' . $e->getMessage()]);
        }
    }

    public function destroy(Load $load)
    {
        $load->delete();
        return redirect()->route('loads.index')->with('success', 'Load deleted successfully');
    }
}