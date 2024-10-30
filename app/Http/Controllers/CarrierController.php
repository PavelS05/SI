<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function index(Request $request)
    {
        $query = Carrier::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('mc', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('contact_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        $carriers = $query->paginate(15);
        return view('carriers.index', compact('carriers'));
    }

    public function create()
    {
        return view('carriers.create');
    }

    public function store(Request $request)
    {
        Carrier::create($request->all());
        return redirect()->route('carriers.index')->with('success', 'Carrier created successfully');
    }

    public function edit(Carrier $carrier)
    {
        return view('carriers.edit', compact('carrier'));
    }

    public function update(Request $request, Carrier $carrier)
    {
        $carrier->update($request->all());
        return redirect()->route('carriers.index')->with('success', 'Carrier updated successfully');
    }

    public function destroy(Carrier $carrier)
    {
        $carrier->delete();
        return redirect()->route('carriers.index')->with('success', 'Carrier deleted successfully');
    }
}