<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function index(Request $request)
    {
        $query = Carrier::query();

        if ($request->has('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('mc', 'LIKE', "%{$request->search}%")
                  ->orWhere('contact_name', 'LIKE', "%{$request->search}%");
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