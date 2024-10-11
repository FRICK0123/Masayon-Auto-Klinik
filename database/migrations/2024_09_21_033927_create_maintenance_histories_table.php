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
        Schema::create('maintenance_histories', function (Blueprint $table) {
            $table->id('historyID')->startingValue('500');
            $table->bigInteger('maintenanceID');
            $table->bigInteger('vehicleID');
            $table->bigInteger('customerID');
            $table->string('owner');
            $table->string('vehicle');
            $table->bigInteger('previous_milage');
            $table->bigInteger('current_milage');
            $table->string('maintenance_type');
            $table->decimal('cost');
            $table->text('maintenance_description');
            $table->string('maintenance_status');
            $table->date('date_performed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_histories');
    }
};
