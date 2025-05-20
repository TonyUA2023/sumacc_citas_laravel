<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\ALaCarteService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
public function index()
{
    // Totales
    $totalCustomers = Customer::count();
    $totalAppointments = Appointment::count();
    $totalServicesALaCarte = ALaCarteService::count();
    $totalServices = Service::count();

    // Citas por estado
    $appointmentsByStatus = Appointment::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');

    // Citas por categoría de servicio
    $appointmentsByCategory = DB::table('appointments')
        ->join('service_vehicle_prices', 'appointments.service_vehicle_price_id', '=', 'service_vehicle_prices.id')
        ->join('services', 'service_vehicle_prices.service_id', '=', 'services.id')
        ->join('service_categories', 'services.category_id', '=', 'service_categories.id')
        ->select('service_categories.name', DB::raw('count(appointments.id) as total'))
        ->groupBy('service_categories.name')
        ->pluck('total', 'name');

    // Ingresos mensuales últimos 6 meses (suma total_price)
    $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

    $monthlyRevenue = Appointment::select(
            DB::raw("DATE_TRUNC('month', appointment_date) as month"),
            DB::raw('SUM(total_price) as total_revenue')
        )
        ->where('appointment_date', '>=', $sixMonthsAgo)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function($item) {
            $monthDate = Carbon::parse($item->month); // <-- corrección aquí
            return [$monthDate->format('Y-m') => $item->total_revenue];
        });

    // Rellenar meses sin datos con 0
    $months = collect();
    for ($i = 0; $i < 6; $i++) {
        $month = Carbon::now()->subMonths(5 - $i)->format('Y-m');
        $months->push($month);
    }

    $monthlyRevenueFull = $months->mapWithKeys(function($month) use ($monthlyRevenue) {
        return [$month => $monthlyRevenue->get($month, 0)];
    });

    return view('admin.dashboard', compact(
        'totalCustomers', 'totalAppointments', 'totalServicesALaCarte', 'totalServices',
        'appointmentsByStatus', 'appointmentsByCategory', 'monthlyRevenueFull'
    ));
}

}