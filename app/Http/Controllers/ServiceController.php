<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\VehicleType;
use App\Models\ServiceVehiclePrice;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Listar servicios con categorías y precios por vehículo
    public function index()
    {
        // Cargar categorías con sus servicios y precios relacionados con tipos de vehículo
        $categories = ServiceCategory::with(['services' => function($q) {
            $q->with('serviceVehiclePrices.vehicleType');
        }])->get();

        // Cargar todos los tipos de vehículo para la vista
        $vehicleTypes = VehicleType::all();

        // Pasar ambas variables a la vista
        return view('admin.services.index', compact('categories', 'vehicleTypes'));
    }

    // Form crear servicio
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    // Guardar servicio
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'recommended_frequency' => 'nullable|string',
            'tagline' => 'nullable|string|max:255',
            'base_duration_minutes' => 'nullable|integer',
            'category_id' => 'required|exists:service_categories,id',
            'starting_price' => 'nullable|numeric',
            'price_label' => 'nullable|string|max:255',
            'exterior_description' => 'nullable|string',
            'interior_description' => 'nullable|string',
            'prices' => 'nullable|array',
            'prices.*.enabled' => 'nullable|boolean',
            'prices.*.price' => 'nullable|numeric|min:0',
        ]);

        $service = Service::create($request->only([
            'name', 'description', 'recommended_frequency', 'tagline',
            'base_duration_minutes', 'category_id', 'starting_price', 'price_label',
            'exterior_description', 'interior_description'
        ]));

        // Guardar precios por vehículo si hay
        if ($request->has('prices')) {
            foreach ($request->input('prices') as $vehicleTypeId => $priceData) {
                if (!empty($priceData['enabled']) && isset($priceData['price'])) {
                    ServiceVehiclePrice::create([
                        'service_id' => $service->id,
                        'vehicle_type_id' => $vehicleTypeId,
                        'price' => $priceData['price'],
                    ]);
                }
            }
        }

        return redirect()->route('services.index')->with('success', 'Servicio creado.');
    }

    // Mostrar servicio
    public function show($id)
    {
        $service = Service::with('category')->findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    // Form editar servicio
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    // Actualizar precios de servicio por vehículo
    public function updatePrices(Request $request, Service $service)
    {
        $request->validate([
            'prices' => 'required|array',
            'prices.*.enabled' => 'nullable|boolean',
            'prices.*.price' => 'nullable|numeric|min:0',
        ]);

        foreach ($request->input('prices') as $vehicleTypeId => $priceData) {
            $svp = ServiceVehiclePrice::where('service_id', $service->id)
                ->where('vehicle_type_id', $vehicleTypeId)
                ->first();

            if (!empty($priceData['enabled']) && isset($priceData['price'])) {
                if ($svp) {
                    $svp->update(['price' => $priceData['price']]);
                } else {
                    ServiceVehiclePrice::create([
                        'service_id' => $service->id,
                        'vehicle_type_id' => $vehicleTypeId,
                        'price' => $priceData['price'],
                    ]);
                }
            } else {
                if ($svp) {
                    $svp->delete();
                }
            }
        }

        return redirect()->route('services.index')->with('success', 'Precios actualizados correctamente.');
    }

    // Actualizar servicio (puedes agregar este método si aún no lo tienes)
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'recommended_frequency' => 'nullable|string',
            'tagline' => 'nullable|string|max:255',
            'base_duration_minutes' => 'nullable|integer',
            'category_id' => 'required|exists:service_categories,id',
            'starting_price' => 'nullable|numeric',
            'price_label' => 'nullable|string|max:255',
            'exterior_description' => 'nullable|string',
            'interior_description' => 'nullable|string',
        ]);

        $service->update($request->only([
            'name', 'description', 'recommended_frequency', 'tagline',
            'base_duration_minutes', 'category_id', 'starting_price', 'price_label',
            'exterior_description', 'interior_description'
        ]));

        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    // Eliminar servicio
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}