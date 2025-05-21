<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ServiceVehiclePrice;
use App\Models\ServiceCategory;
use App\Models\VehicleType;
use App\Models\ALaCarteService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PublicController extends Controller
{
    // Página principal
    public function home()
    {
        return view('public.index');
    }

public function storeBooking(Request $request)
{
    $data = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'service_vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|string',
        'total_price' => 'required|numeric',
        'extras' => 'nullable|array',
        'extras.*' => 'exists:a_la_carte_services,id',
    ]);

    $dateTimeStr = $data['appointment_date'] . ' ' . $data['appointment_time'];

    try {
        $appointmentDateTime = \Carbon\Carbon::parse($dateTimeStr);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Fecha u hora inválida: ' . $e->getMessage(),
        ], 422);
    }

    DB::beginTransaction();

    try {
        $appointment = Appointment::create([
            'customer_id' => $data['customer_id'],
            'service_vehicle_price_id' => $data['service_vehicle_price_id'],
            'appointment_date' => $appointmentDateTime,
            'status' => 'Pendiente',
            'total_price' => $data['total_price'],
            'admin_user_id' => null,
        ]);

        if (!empty($data['extras'])) {
            foreach ($data['extras'] as $extraId) {
                $appointment->appointmentExtras()->create([
                    'a_la_carte_service_id' => $extraId,
                    'quantity' => 1,
                ]);
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Cita creada correctamente.',
            'appointment_id' => $appointment->id,
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al guardar la cita: ' . $e->getMessage(),
        ], 500);
    }
}

    // Listado de servicios disponibles
    public function services()
    {
        $categories = ServiceCategory::with(['services' => function($q) {
            $q->with('serviceVehiclePrices.vehicleType');
        }])->get();

        $vehicleTypes = VehicleType::all();

        return view('public.services', compact('categories', 'vehicleTypes'));
    }

    public function carWash()
    {
        $categories = ServiceCategory::with(['services' => function($q) {
            $q->with('serviceVehiclePrices.vehicleType');
        }])->get();

        $vehicleTypes = VehicleType::all();

        return view('public.car-wash', compact('categories', 'vehicleTypes'));
    }

    public function products()
    {
        // No necesitamos cargar datos de BD porque los productos son estáticos
        return view('public.products');
    }

    // Detalle de una cita (solo lectura)
    public function appointmentDetails($id)
    {
        $appointment = Appointment::with(['customer', 'serviceVehiclePrice.vehicleType', 'appointmentExtras.aLaCarteService'])
                        ->findOrFail($id);
        return view('public.appointments.show', compact('appointment'));
    }

        public function showAppointmentForm()
    {
        $services = ServiceVehiclePrice::with('service', 'vehicleType')->get();
        return view('public.book_appointment', compact('services'));
    }

    // Guardar cita desde formulario público
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',
            'service_vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
        ]);

        // Crear o buscar cliente
        $customer = Customer::firstOrCreate(
            ['email' => $request->customer_email],
            [
                'name' => $request->customer_name,
                'phone_number' => $request->customer_phone,
            ]
        );

        // Crear cita
        Appointment::create([
            'customer_id' => $customer->id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pendiente',
            'service_vehicle_price_id' => $request->service_vehicle_price_id,
            'total_price' => $request->total_price ?? null,
            'admin_user_id' => null,
        ]);

        return redirect()->route('public.appointments.create')->with('success', 'Cita agendada correctamente. Nos pondremos en contacto.');
    }

    // Ejemplo en PublicController
public function showBookingForm($serviceId)
{
    $service = Service::with(['serviceVehiclePrices.vehicleType'])
        ->findOrFail($serviceId);

    $vehiclePrices = $service->serviceVehiclePrices;
    $extraServices = ALaCarteService::all();

    // Obtener citas futuras ocupadas con estado Pendiente, Aceptado o Realizado
    $blockedAppointments = Appointment::whereIn('status', ['Pendiente', 'Aceptado', 'Realizado'])
        ->whereDate('appointment_date', '>=', now()->toDateString())
        ->selectRaw("DATE(appointment_date) as date, EXTRACT(HOUR FROM appointment_date) as hour")
        ->get()
        ->map(function($a) {
            return [
                'date' => $a->date,
                'hour' => str_pad($a->hour, 2, '0', STR_PAD_LEFT) . ':00'
            ];
        })
        ->toArray();

    return view('public.book_appointment', compact('service', 'vehiclePrices', 'extraServices', 'blockedAppointments'));
}

}