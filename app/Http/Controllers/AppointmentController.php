<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\ServiceVehiclePrice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['storeBooking']);
    }

    // Mostrar listado
    public function index()
    {
        // Cargar citas con relaciones necesarias
        $appointments = Appointment::with(['customer', 'serviceVehiclePrice.service', 'serviceVehiclePrice.vehicleType'])->get();

        // Preparar los datos para el calendario en JS (JSON seguro)
        $appointmentsData = $appointments->map(function($a) {
            return [
                'id' => $a->id,
                'title' => $a->customer->name ?? 'Sin cliente',
                'start' => Carbon::parse($a->appointment_date)->format('Y-m-d\TH:i:s'),
                'end' => Carbon::parse($a->appointment_date)->addHours(2)->format('Y-m-d\TH:i:s'),
                'classNames' => [$a->status],
                'extendedProps' => [
                    'status' => $a->status,
                    'service' => $a->serviceVehiclePrice->service->name ?? '',
                    'vehicle' => $a->serviceVehiclePrice->vehicleType->name ?? '',
                ]
            ];
        });

        // También carga clientes para el select del modal
        $customers = \App\Models\Customer::all();

        return view('admin.appointments.index', compact('appointmentsData', 'customers'));
    }

    // Form para crear cita
    public function create()
    {
        $customers = Customer::all();
        $serviceVehiclePrices = ServiceVehiclePrice::with('service', 'vehicleType')->get();
        return view('admin.appointments.create', compact('customers', 'serviceVehiclePrices'));
    }

    // Guardar cita
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'appointment_date' => 'required|date',
            'status' => 'required|string',
            'service_vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
            'total_price' => 'nullable|numeric',
            'admin_user_id' => 'nullable|exists:admin_users,id',
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')->with('success', 'Cita creada exitosamente.');
    }

    // Mostrar detalle
    public function show($id)
    {
        $appointment = Appointment::with(['customer', 'adminUser', 'serviceVehiclePrice.vehicleType', 'appointmentExtras.aLaCarteService'])
                        ->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    // Form para editar cita
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $customers = Customer::all();
        $serviceVehiclePrices = ServiceVehiclePrice::with('service', 'vehicleType')->get();
        return view('admin.appointments.edit', compact('appointment', 'customers', 'serviceVehiclePrices'));
    }

    // Actualizar cita
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'appointment_date' => 'required|date',
            'status' => 'required|string',
            'service_vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
            'total_price' => 'nullable|numeric',
            'admin_user_id' => 'nullable|exists:admin_users,id',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Cita actualizada exitosamente.');
    }

    // Eliminar cita
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Cita eliminada exitosamente.');
    }

    public function calendar()
    {
        return view('admin.appointments.index');
    }

    public function events()
    {
        $appointments = Appointment::with('customer', 'serviceVehiclePrice.service')->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->serviceVehiclePrice->service->name ?? 'Servicio',
                'start' => $appointment->appointment_date,
                'end' => \Carbon\Carbon::parse($appointment->appointment_date)->addMinutes($appointment->serviceVehiclePrice->service->base_duration_minutes ?? 60)->toDateTimeString(),
                'status' => $appointment->status,
                'customer_name' => $appointment->customer->name ?? 'N/A',
            ];
        });

        return response()->json($events);
    }


}