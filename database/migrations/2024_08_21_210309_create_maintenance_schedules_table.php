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
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id('maintenanceID')->startingValue('5000');
            $table->bigInteger('vehicleID');
            $table->string('maintenance_type');
            $table->string('PMS_services');
            $table->date('scheduled_date');
            $table->date('last_maintenance_date');
            $table->integer('scheduled_interval');
            $table->string('oil_type')->nullable();
            $table->integer('current_milage')->nullable();
            $table->integer('next_milage_schedule')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};
