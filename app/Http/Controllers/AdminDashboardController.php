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
        
        // Citas del día actual
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();

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
                $monthDate = Carbon::parse($item->month);
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

        

        // Citas por día de la semana (para identificar qué días tienen más citas)
        $appointmentsByDayOfWeek = Appointment::select(
                DB::raw("EXTRACT(DOW FROM appointment_date) as day_of_week"),
                DB::raw('count(*) as total')
            )
            ->groupBy('day_of_week')
            ->orderBy('day_of_week')
            ->get()
            ->mapWithKeys(function($item) {
                // Convertir número de día (0-6, donde 0 es domingo) a nombre del día
                $dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                return [$dayNames[$item->day_of_week] => $item->total];
            });

        // Citas por hora del día (para identificar horas pico)
        $appointmentsByHour = Appointment::select(
                DB::raw("EXTRACT(HOUR FROM appointment_date) as hour"),
                DB::raw('count(*) as total')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->mapWithKeys(function($item) {
                // Formato de hora para mostrar (9:00, 10:00, etc.)
                return [sprintf('%02d:00', $item->hour) => $item->total];
            });

        // Próximas citas (para mostrar en un widget)
        $upcomingAppointments = Appointment::with(['customer', 'serviceVehiclePrice.service', 'serviceVehiclePrice.vehicleType'])
            ->where('appointment_date', '>=', Carbon::today())
            ->orderBy('appointment_date', 'asc')
            ->limit(5)
            ->get();
            
        // Citas por semana (para gráfico de tendencia)
        $weeksAgo = Carbon::now()->subWeeks(11)->startOfWeek();
        
        $appointmentsByWeek = Appointment::select(
                DB::raw("DATE_TRUNC('week', appointment_date) as week"),
                DB::raw('count(*) as total')
            )
            ->where('appointment_date', '>=', $weeksAgo)
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->mapWithKeys(function($item) {
                $weekDate = Carbon::parse($item->week);
                return [$weekDate->format('d M') => $item->total];
            });

        // Variables para compartir globalmente con el layout
        view()->share('todayAppointments', $todayAppointments);
        view()->share('totalCustomers', $totalCustomers);
        view()->share('totalAppointments', $totalAppointments);

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalAppointments', 'totalServicesALaCarte', 'totalServices',
            'appointmentsByStatus', 'appointmentsByCategory', 'monthlyRevenueFull', 'todayAppointments',
            'appointmentsByDayOfWeek', 'appointmentsByHour', 'upcomingAppointments', 'appointmentsByWeek'
        ));
    }
}