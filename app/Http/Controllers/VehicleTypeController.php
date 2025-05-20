<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = ServiceCategory::with(['services.serviceVehiclePrices.vehicleType'])->get();
        $vehicleTypes = VehicleType::all();
        return view('admin.vehicle_types.index', compact('categories', 'vehicleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        VehicleType::create($request->only(['name', 'icon']));

        return redirect()->route('vehicle_types.index')->with('success', 'Tipo de vehículo creado.');
    }

    public function update(Request $request, VehicleType $vehicle_type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        $vehicle_type->update($request->only(['name', 'icon']));

        return redirect()->route('vehicle_types.index')->with('success', 'Tipo de vehículo actualizado.');
    }

    public function destroy(VehicleType $vehicle_type)
    {
        // Opcional: valida relaciones antes de eliminar

        $vehicle_type->delete();

        return redirect()->route('vehicle_types.index')->with('success', 'Tipo de vehículo eliminado.');
    }
}