<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\ALaCarteServiceController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ServiceVehiclePriceController;

// Rutas públicas
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/category/{id}', [PublicController::class, 'showCategoryServices'])->name('public.category.services');
Route::get('/service/{id}', [PublicController::class, 'showServiceDetail'])->name('public.service.detail');

Route::get('/book/{serviceId}', [PublicController::class, 'showBookingForm'])->name('public.book');
Route::post('/book', [PublicController::class, 'storeBooking'])->name('public.book.store');

Route::get('/appointments/{id}', [PublicController::class, 'appointmentDetails'])->name('public.appointments.show');

Route::get('/detailing-services', [PublicController::class, 'services'])->name('public.services');
Route::get('/car-wash', [PublicController::class, 'carWash'])->name('public.carwash');
Route::get('/products', [PublicController::class, 'products'])->name('public.products');

Route::post('/customer/store', [CustomerController::class, 'store'])->name('public.customer.store');

// Admin Auth routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Admin protected routes
Route::middleware('auth:admin')->prefix('admin')->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Define la ruta 'events' ANTES que resource appointments
    Route::get('appointments/events', [AppointmentController::class, 'events'])->name('appointments.events');

    // Ruta para actualizar estado de cita, dentro del grupo y sin repetir 'admin' en URI
    Route::put('appointments/{appointment}/update-status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    Route::resource('customers', CustomerController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('vehicle_types', VehicleTypeController::class);
    Route::resource('a_la_carte_services', ALaCarteServiceController::class);
    Route::resource('service_categories', ServiceCategoryController::class);

    Route::resource('service_vehicle_prices', ServiceVehiclePriceController::class)->except(['show', 'create', 'edit']);

    Route::put('services/{service}/prices', [ServiceController::class, 'updatePrices'])->name('services.updatePrices');
});

// Ruta fuera del grupo admin, con middleware individual
Route::put('/services/vehicle_prices/{service}/{vehicleType}', [ServiceVehiclePriceController::class, 'updateByServiceAndVehicle'])
    ->name('service_vehicle_prices.updateByServiceAndVehicle')
    ->middleware('auth:admin');