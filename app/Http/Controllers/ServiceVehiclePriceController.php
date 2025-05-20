<?php

namespace App\Http\Controllers;

use App\Models\ServiceVehiclePrice;
use App\Models\Service;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class ServiceVehiclePriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $prices = ServiceVehiclePrice::with('service', 'vehicleType')->paginate(10);
        return view('admin.service_vehicle_prices.index', compact('prices'));
    }

    public function create()
    {
        $services = Service::all();
        $vehicleTypes = VehicleType::all();
        return view('admin.service_vehicle_prices.create', compact('services', 'vehicleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'price' => 'required|numeric|min:0',
        ]);

        ServiceVehiclePrice::create($request->all());

        return redirect()->route('service_vehicle_prices.index')->with('success', 'Precio guardado exitosamente.');
    }

    public function show($id)
    {
        $price = ServiceVehiclePrice::with('service', 'vehicleType')->findOrFail($id);
        return view('admin.service_vehicle_prices.show', compact('price'));
    }

    public function edit($id)
    {
        $price = ServiceVehiclePrice::findOrFail($id);
        $services = Service::all();
        $vehicleTypes = VehicleType::all();
        return view('admin.service_vehicle_prices.edit', compact('price', 'services', 'vehicleTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'price' => 'required|numeric|min:0',
        ]);

        $price = ServiceVehiclePrice::findOrFail($id);
        $price->update($request->all());

        return redirect()->route('service_vehicle_prices.index')->with('success', 'Precio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $price = ServiceVehiclePrice::findOrFail($id);
        $price->delete();

        return redirect()->route('service_vehicle_prices.index')->with('success', 'Precio eliminado exitosamente.');
    }

    public function updateAjax(Request $request, ServiceVehiclePrice $serviceVehiclePrice)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $serviceVehiclePrice->price = $request->price;
        $serviceVehiclePrice->save();

        return response()->json(['success' => true, 'price' => $serviceVehiclePrice->price]);
    }

    public function updateByServiceAndVehicle(Request $request, $serviceId, $vehicleTypeId)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $priceEntry = ServiceVehiclePrice::where('service_id', $serviceId)
                    ->where('vehicle_type_id', $vehicleTypeId)
                    ->first();

        if(!$priceEntry) {
            // Crear nuevo registro si no existe
            $priceEntry = ServiceVehiclePrice::create([
                'service_id' => $serviceId,
                'vehicle_type_id' => $vehicleTypeId,
                'price' => $request->price,
            ]);
        } else {
            $priceEntry->price = $request->price;
            $priceEntry->save();
        }

        return response()->json(['success' => true, 'price' => $priceEntry->price]);
    }

}