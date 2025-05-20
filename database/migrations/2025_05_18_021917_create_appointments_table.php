<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->timestampTz('appointment_date');
            $table->string('status');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->foreignId('service_vehicle_price_id')->constrained('service_vehicle_prices')->onDelete('cascade');
            $table->foreignId('admin_user_id')->nullable()->constrained('admin_users')->onDelete('set null');
            $table->timestampsTz();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
