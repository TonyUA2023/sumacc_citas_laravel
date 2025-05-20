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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('recommended_frequency')->nullable();
            $table->string('tagline')->nullable();
            $table->integer('base_duration_minutes')->nullable();
            $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade');
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->string('price_label')->nullable();
            $table->text('exterior_description')->nullable();
            $table->text('interior_description')->nullable();
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
        Schema::dropIfExists('services');
    }
};
