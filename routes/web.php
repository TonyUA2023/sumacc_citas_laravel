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

// Formulario y almacenamiento de reserva
Route::get('/book/{serviceId}', [PublicController::class, 'showBookingForm'])->name('public.book');
Route::post('/book', [PublicController::class, 'storeBooking'])->name('public.book.store');

// Mostrar cita agendada (confirmación)
Route::get('/appointments/{id}', [PublicController::class, 'appointmentDetails'])->name('public.appointments.show');

// Otras páginas públicas
Route::get('/detailing-services', [PublicController::class, 'services'])->name('public.services');
Route::get('/car-wash', [PublicController::class, 'carWash'])->name('public.carwash');
Route::get('/products', [PublicController::class, 'products'])->name('public.products');

// Rutas para gestionar clientes vía API/ajax (guardado cliente)
Route::post('/customer/store', [CustomerController::class, 'store'])->name('public.customer.store');

// Rutas para autenticación admin
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Rutas protegidas admin con middleware auth:admin
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('customers', CustomerController::class); // <--- habilitar clientes

    Route::resource('appointments', AppointmentController::class);
    Route::resource('services', ServiceController::class);
    // No se define resource customers aquí para admin, se puede activar si es necesario
    // Route::resource('customers', CustomerController::class);
    Route::resource('vehicle_types', VehicleTypeController::class);
    Route::resource('a_la_carte_services', ALaCarteServiceController::class);
    Route::resource('service_categories', ServiceCategoryController::class);

    // Servicio precios vehículo
    Route::resource('service_vehicle_prices', ServiceVehiclePriceController::class)->except(['show', 'create', 'edit']);

    // Ruta para actualizar precios de un servicio (custom)
    Route::put('services/{service}/prices', [ServiceController::class, 'updatePrices'])->name('services.updatePrices');
});

Route::put('/services/vehicle_prices/{service}/{vehicleType}', [ServiceVehiclePriceController::class, 'updateByServiceAndVehicle'])
    ->name('service_vehicle_prices.updateByServiceAndVehicle')
    ->middleware('auth:admin');