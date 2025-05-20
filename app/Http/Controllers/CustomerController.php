<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    

// CustomerController.php
    public function store(Request $request)
    {
        $data = $request->only(['name', 'phone_number', 'email', 'address']);

        // Puedes asignar created_at manualmente
        $data['created_at'] = Carbon::now();

        $customer = Customer::create($data);

        return response()->json(['success' => true, 'customer' => $customer]);
    }


    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Cliente eliminado correctamente.');
    }
}