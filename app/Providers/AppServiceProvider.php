<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use App\Models\Customer;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartir variables globales en todas las vistas de la aplicación
        View::composer('admin.layout', function ($view) {
            $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
            $totalCustomers = Customer::count();
            $totalAppointments = Appointment::count();
            
            $view->with('todayAppointments', $todayAppointments);
            $view->with('totalCustomers', $totalCustomers);
            $view->with('totalAppointments', $totalAppointments);
        });
    }
}