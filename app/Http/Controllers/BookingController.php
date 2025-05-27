<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\ALaCarteService;
use App\Models\ServiceVehiclePrice;

class BookingController extends Controller
{
    /** Step 1: Show and store selected service */
    public function showService(Service $service)
    {
        return view('booking.service', compact('service'));
    }

    public function postService(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        Session::put('booking.service_id', $request->service_id);
        return redirect()->route('booking.vehicle');
    }

    /** Step 2: Show and store selected vehicle */
    public function showVehicle()
    {
        $service = Service::findOrFail(Session::get('booking.service_id'));
        $vehiclePrices = $service->serviceVehiclePrices;
        return view('booking.vehicle', compact('service', 'vehiclePrices'));
    }

public function postVehicle(Request $request)
{
    $request->validate([
        'vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
        'notes' => 'required|nullable|string|max:1000',
    ]);

    Session::put('booking.vehicle_price_id', $request->vehicle_price_id);
    Session::put('booking.notes', $request->notes); // Guarda las notas en la sesión

    $service = Service::find(Session::get('booking.service_id'));

    if ($service && $service->category_id == 2) {
        return redirect()->route('booking.datetime');
    }

    return redirect()->route('booking.extras');
}


    /** Step 3: Show and store extras */
    public function showExtras()
    {
        $extras = ALaCarteService::all();
        return view('booking.extras', compact('extras'));
    }

    public function postExtras(Request $request)
    {
        $request->validate([
            'extras'   => 'nullable|array',
            'extras.*' => 'exists:a_la_carte_services,id',
        ]);

        Session::put('booking.extras', $request->extras ?? []);
        return redirect()->route('booking.datetime');
    }

    /** Step 4: Show and store date & time */
   public function showDateTime()
    {
        // Recupera todo lo que llevas en sesión
        $b = Session::get('booking', []);

        // Busca los modelos
        $service = Service::findOrFail($b['service_id'] ?? 0);
        $vehicle = ServiceVehiclePrice::findOrFail($b['vehicle_price_id'] ?? 0);
        $extras  = !empty($b['extras'])
                    ? ALaCarteService::whereIn('id', $b['extras'])->get()
                    : collect();

        // Genera el array de citas bloqueadas
        $blockedAppointments = Appointment::whereIn('status', ['Pendiente','Aceptado','Realizado'])
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->selectRaw("DATE(appointment_date) as date, EXTRACT(HOUR FROM appointment_date) as hour")
            ->get()
            ->map(fn($a) => [
                'date' => $a->date,
                'hour' => str_pad($a->hour, 2, '0', STR_PAD_LEFT) . ':00',
            ])
            ->toArray();

        return view('booking.datetime', compact(
            'service',
            'vehicle',
            'extras',
            'blockedAppointments'
        ));
    }

    public function postDateTime(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        Session::put('booking.appointment_date', $request->appointment_date);
        Session::put('booking.appointment_time', $request->appointment_time);
        return redirect()->route('booking.client');
    }

    /** Step 5: Show and store client info */

        public function showClient()
    {
        $b = session('booking', []);

        // Your service
        $service = Service::findOrFail($b['service_id'] ?? 0);

        // The chosen vehicle/price row
        $vehicle = ServiceVehiclePrice::with('vehicleType')
            ->findOrFail($b['vehicle_price_id'] ?? 0);

        // Any extras
        $extras = ! empty($b['extras'])
            ? ALaCarteService::whereIn('id', $b['extras'])->get()
            : collect();

        // Load or stub a Customer
        if (! empty($b['customer_id'])) {
            $customer = Customer::find($b['customer_id']);
        } else {
            $customer = new Customer([
                'name'         => $b['name']         ?? '',
                'email'        => $b['email']        ?? '',
                'phone_number' => $b['phone_number'] ?? '',
                'address'      => $b['address']      ?? '',
            ]);
        }

        return view('booking.client', compact(
            'service',
            'vehicle',
            'extras',
            'customer'
        ));
    }

    public function postClient(Request $request)
    {
        // Valida
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:50',
            'address'      => 'required|string|max:255',
        ]);

        // Crea o actualiza el cliente en BD (por email único)
        $customer = Customer::updateOrCreate(
            ['email' => $data['email']],
            array_merge($data, ['created_at' => now()])
        );

        // Guarda su ID en sesión
        session()->put('booking.customer_id', $customer->id);

        // Avanza al paso siguiente
        return redirect()->route('booking.confirm');
    }
    /** Step 6: Show confirmation and persist appointment */
    public function showConfirm()
    {
        $b = Session::get('booking', []);
        $service = Service::find($b['service_id'] ?? null);
        $vehicle = ServiceVehiclePrice::find($b['vehicle_price_id'] ?? null);
        $extras  = !empty($b['extras'])
                    ? ALaCarteService::whereIn('id', $b['extras'])->get()
                    : collect();
        $customer = Customer::find($b['customer_id'] ?? null);

        return view('booking.confirm', compact('service', 'vehicle', 'extras', 'customer', 'b'));
    }

    public function postConfirm()
    {
        $b = Session::get('booking');

        DB::beginTransaction();
        try {
            $appointment = Appointment::create([
                'customer_id'              => $b['customer_id'],
                'service_vehicle_price_id' => $b['vehicle_price_id'],
                'appointment_date'         => Carbon::parse($b['appointment_date'].' '.$b['appointment_time']),
                'status'                   => 'Pendiente',
                'total_price'              => $this->calculateTotal($b),
                'admin_user_id'            => null,
                'notes' => $b['notes'] ?? null,
            ]);

            foreach ($b['extras'] ?? [] as $extraId) {
                $appointment->appointmentExtras()->create([
                    'a_la_carte_service_id' => $extraId,
                    'quantity'              => 1,
                ]);
            }

            DB::commit();
            Session::forget('booking');

            return redirect()
                ->route('public.appointments.show', $appointment->id)
                ->with('success', 'Cita creada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al guardar la cita: '.$e->getMessage());
        }
    }

    /** Cancel wizard and clear session */
    public function cancel()
    {
        Session::forget('booking');
        return redirect()->route('public.home');
    }

    /** Calculate total cost */
    private function calculateTotal(array $b): float
    {
        $base  = ServiceVehiclePrice::find($b['vehicle_price_id'])->price;
        $extra = ALaCarteService::whereIn('id', $b['extras'] ?? [])->sum('price');
        return $base + $extra;
    }

    public function postSelectVehicle(Request $request)
    {
        $request->validate([
            'vehicle_price_id' => 'required|exists:service_vehicle_prices,id',
        ]);

        session(['booking.vehicle_price_id' => $request->vehicle_price_id]);

        // Recuperar el servicio seleccionado desde la sesión
        $service = \App\Models\Service::with('category')->find(session('booking.service_id'));

        if ($service && $service->category_id == 2) {
            // Si es Mobile Detailing, saltar el paso de extras
            return redirect()->route('booking.customer_data');
        }

        // Caso contrario, continuar al paso de extras
        return redirect()->route('booking.extras');
    }

}