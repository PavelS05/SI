<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if (auth()->user()->role === 'sales') {
            $query->where(function ($q) {
                $q->where('sales_rep1', auth()->user()->username)
                    ->orWhere('sales_rep2', auth()->user()->username);
            });
        }

        // Căutare
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('contact_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }

        $customers = $query->paginate(15);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $salesUsers = User::where('role', 'sales')->get();
        return view('customers.create', compact('salesUsers'));
    }

    public function store(Request $request)
    {
        // Dacă userul e sales, îl setăm automat ca sales_rep1
        $data = $request->all();
        if (auth()->user()->role === 'sales') {
            $data['sales_rep1'] = auth()->user()->username;
        }

        Customer::create($data);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}