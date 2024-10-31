<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Illuminate\Http\Request;
use App\Models\User;


class CostumerController extends Controller
{
public function index(Request $request)
{
   $query = Costumer::query();

   if (auth()->user()->role === 'sales') {
       $query->where(function($q) {
           $q->where('sales_rep1', auth()->user()->username)
             ->orWhere('sales_rep2', auth()->user()->username);
       });
   }

   // Căutare
   if ($request->has('search')) {
       $searchTerm = $request->search;
       $query->where(function($q) use ($searchTerm) {
           $q->where('name', 'LIKE', "%{$searchTerm}%")
             ->orWhere('contact_name', 'LIKE', "%{$searchTerm}%")
             ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
             ->orWhere('email', 'LIKE', "%{$searchTerm}%");
       });
   }

   $costumers = $query->paginate(15);
   return view('costumers.index', compact('costumers'));
}

public function create()
{
   $salesUsers = User::where('role', 'sales')->get();
   return view('costumers.create', compact('salesUsers'));
}

public function store(Request $request)
{
   // Dacă userul e sales, îl setăm automat ca sales_rep1
   $data = $request->all();
   if (auth()->user()->role === 'sales') {
       $data['sales_rep1'] = auth()->user()->username;
   }

   Costumer::create($data);
   return redirect()->route('costumers.index')->with('success', 'Customer created successfully');
}

   public function edit(Costumer $costumer)
   {
       return view('costumers.edit', compact('costumer'));
   }

   public function update(Request $request, Costumer $costumer)
   {
       $costumer->update($request->all());
       return redirect()->route('costumers.index')->with('success', 'Customer updated successfully');
   }

   public function destroy(Costumer $costumer)
   {
       $costumer->delete();
       return redirect()->route('costumers.index')->with('success', 'Customer deleted successfully');
   }
}