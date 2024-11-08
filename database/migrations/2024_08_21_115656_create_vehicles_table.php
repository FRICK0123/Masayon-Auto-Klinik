<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicleID')->startingValue(1000);
            $table->bigInteger('customerID');
            $table->string('vehicle_image');
            $table->string('make');
            $table->string('model');
            $table->string('year_of_manufacture');
            $table->bigInteger('milage');
            $table->string('engine_number');
            $table->string('vehicle_identification_number');
            $table->string('chassis_number');
            $table->string('plate_number');
            $table->string('engine_type');
            $table->boolean('isDeactivated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
