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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notificationID')->startingValue(50);
            $table->bigInteger('customerID');
            $table->bigInteger('vehicleID');
            $table->bigInteger('maintenanceID');
            $table->string('owner');
            $table->string('vehicle');
            $table->string('maintenance_type');
            $table->text('content');
            $table->boolean('isConfirmed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
