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
            $table->bigInteger('customerID');
            $table->string('maintenance_type');
            $table->text('PMS_services')->nullable();
            $table->date('scheduled_date');
            $table->date('last_maintenance_date');
            $table->integer('scheduled_interval');
            $table->string('oil_type')->nullable();
            $table->integer('current_milage')->nullable();
            $table->integer('next_milage_schedule')->nullable();
            $table->boolean('isAppointed');
            $table->timestamp('appointment_date');
            $table->boolean('isDeactivated');
            $table->boolean('isRegarded');
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
