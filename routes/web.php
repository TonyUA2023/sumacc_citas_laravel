<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\ALaCarteServiceController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceVehiclePriceController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])
     ->name('public.home');

Route::get('/category/{id}', [PublicController::class, 'showCategoryServices'])
     ->name('public.category.services');

Route::get('/service/{id}', [PublicController::class, 'showServiceDetail'])
     ->name('public.service.detail');

Route::get('/detailing-services', [PublicController::class, 'services'])
     ->name('public.services');

Route::get('/car-wash', [PublicController::class, 'carWash'])
     ->name('public.carwash');

Route::get('/products', [PublicController::class, 'products'])
     ->name('public.products');

Route::post('/customer/store', [CustomerController::class, 'store'])
     ->name('public.customer.store');

Route::get('/appointments/{id}', [PublicController::class, 'appointmentDetails'])
     ->name('public.appointments.show');


/*
|--------------------------------------------------------------------------
| Booking Wizard Routes (multi-step)
|--------------------------------------------------------------------------
*/
Route::prefix('booking')
     ->name('booking.')
     ->group(function () {

    // Step 1: Select Service
    Route::get('service/{service}', [BookingController::class, 'showService'])
         ->name('service');
    Route::post('service', [BookingController::class, 'postService'])
         ->name('service.store');

    // Step 2: Select Vehicle
    Route::get('vehicle', [BookingController::class, 'showVehicle'])
         ->name('vehicle');
    Route::post('vehicle', [BookingController::class, 'postVehicle'])->name('vehicle.store');


    // Step 3: Extras (solo si NO es Mobile Detailing)
    Route::get('extras', function () {
        $service = \App\Models\Service::find(session('booking.service_id'));

        if ($service && $service->category_id == 2) {
            return redirect()->route('booking.datetime');
        }

        return app(BookingController::class)->showExtras();
    })->name('extras');

    Route::post('extras', [BookingController::class, 'postExtras'])
         ->name('extras.store');

    // Step 4: Date & Time
    Route::get('datetime', [BookingController::class, 'showDateTime'])
         ->name('datetime');
    Route::post('datetime', [BookingController::class, 'postDateTime'])
         ->name('datetime.store');

    // Step 5: Client Info
    Route::get('client', [BookingController::class, 'showClient'])
         ->name('client');
    Route::post('client', [BookingController::class, 'postClient'])
         ->name('client.store');

    // Step 6: Confirmation
    Route::get('confirm', [BookingController::class, 'showConfirm'])
         ->name('confirm');
    Route::post('confirm', [BookingController::class, 'postConfirm'])
         ->name('confirm.store');

    // Cancel at any step
    Route::post('cancel', [BookingController::class, 'cancel'])
         ->name('cancel');
});


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('login',  [AdminAuthController::class, 'showLoginForm'])
         ->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])
         ->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])
         ->name('admin.logout');
});


/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')
     ->prefix('admin')
     ->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])
         ->name('admin.dashboard');

    // Appointment events for calendar
    Route::get('appointments/events', [AppointmentController::class, 'events'])
         ->name('appointments.events');

    // Update appointment status
    Route::put(
        'appointments/{appointment}/update-status',
        [AppointmentController::class, 'updateStatus']
    )
    ->name('appointments.updateStatus');

    Route::resource('customers', CustomerController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('vehicle_types', VehicleTypeController::class);
    Route::resource('a_la_carte_services', ALaCarteServiceController::class);
    Route::resource('service_categories', ServiceCategoryController::class);

    Route::resource('service_vehicle_prices', ServiceVehiclePriceController::class)
         ->except(['show', 'create', 'edit']);

    Route::put(
        'services/{service}/prices',
        [ServiceController::class, 'updatePrices']
    )
    ->name('services.updatePrices');
});

// Single update route for service-vehicle price (outside resource)
Route::put(
    '/services/vehicle_prices/{service}/{vehicleType}',
    [ServiceVehiclePriceController::class, 'updateByServiceAndVehicle']
)
->middleware('auth:admin')
->name('service_vehicle_prices.updateByServiceAndVehicle');