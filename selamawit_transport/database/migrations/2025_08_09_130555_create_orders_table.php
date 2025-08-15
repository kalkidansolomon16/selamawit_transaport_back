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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->string('order_name');
            $table->string('client_name');
            $table->string('plate_number');
            $table->string('driver_name');
            $table->string('phone_number');
            $table->string('loading_place');
            $table->string('destination');
            $table->string('load_type');
            $table->float('quintal');
            $table->float('given_tariff');
            $table->float('sub_tariff');
            $table->float('total_revenue');
            $table->float('revenue');
            $table->float('to_be_paid');
            $table->date('arrival_at_loading_site');
            $table->date('loading_date');
            $table->string('current_condition');
            $table->string('truks_owner');
            $table->string('payment_collected');
            $table->string('payment_done')->nullable();
            $table->string('month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
