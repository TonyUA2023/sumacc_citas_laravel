<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\ServiceVehiclePrice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['storeBooking']);
    }

    /**
     * Mostrar la vista principal del calendario
        */
        
    public function index()
    {
        $customers = Customer::all();

        $serviceVehiclePrices = ServiceVehiclePrice::with('service', 'vehicleType')->get();

        $appointments = Appointment::with('customer', 'serviceVehiclePrice.service', 'serviceVehiclePrice.vehicleType')
            ->paginate(10);

        return view('admin.appointments.index', compact('customers', 'serviceVehiclePrices', 'appointments'));
    }

public function events()
{
    $appointments = Appointment::with([
        'customer',
        'serviceVehiclePrice.service',
        'serviceVehiclePrice.vehicleType',
        'appointmentExtras.aLaCarteService'
    ])->get();

    $events = $appointments->map(function ($appointment) {
        $customer = $appointment->customer;
        return [
            'id'    => $appointment->id,
            'title' => optional($appointment->serviceVehiclePrice->service)->name ?? 'N/A',
            'start' => optional($appointment->appointment_date)?->format('Y-m-d\TH:i:s') ?? now()->format('Y-m-d\TH:i:s'),
            'end'   => optional($appointment->appointment_date)?->addHour()->format('Y-m-d\TH:i:s') ?? now()->addHour()->format('Y-m-d\TH:i:s'),
            'extendedProps' => [
                'customer_name'    => $customer->name ?? 'N/A',
                'customer_address' => $customer->address ?? '—',
                'customer_phone'   => $customer->phone_number  ?? '—',
                'customer_email'   => $customer->email  ?? '—',
                'vehicle'          => optional($appointment->serviceVehiclePrice->vehicleType)->name ?? 'N/A',
                'total_price'      => (float) ($appointment->total_price ?? 0),
                'status'           => $appointment->status ?? 'pendiente',
                'extras'           => $appointment->appointmentExtras->map(function($extra) {
                    return [
                        'name'     => optional($extra->aLaCarteService)->name ?? 'Extra',
                        'quantity' => $extra->quantity
                    ];
                })->toArray(),
            ],
        ];
    });

    return response()->json($events);
}


    /**
     * Mostrar formulario para crear una cita
     */
    public function create()
    {
        $customers = Customer::all();
        $serviceVehiclePrices = ServiceVehiclePrice::with('service', 'vehicleType')->get();
        return view('admin.appointments.create', compact('customers', 'serviceVehiclePrices'));
    }

    /**
     * Guardar nueva cita
     */
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

    /**
     * Mostrar detalle de cita
     */
    public function show($id)
    {
        $appointment = Appointment::with(['customer', 'adminUser', 'serviceVehiclePrice.vehicleType', 'appointmentExtras.aLaCarteService'])
            ->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Mostrar formulario para editar cita
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $customers = Customer::all();
        $serviceVehiclePrices = ServiceVehiclePrice::with('service', 'vehicleType')->get();
        return view('admin.appointments.edit', compact('appointment', 'customers', 'serviceVehiclePrices'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pendiente,aceptado,realizado,rechazado',
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['message' => 'Estado actualizado']);
    }


    /**
     * Actualizar cita existente
     */
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

    /**
     * Eliminar cita
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Cita eliminada exitosamente.');
    }
}