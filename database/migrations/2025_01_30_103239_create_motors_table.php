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
        Schema::create('motors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('make');
            $table->string('model')->unique();
            $table->year('year');
            $table->string('vehicle_number');
            $table->string('class');
            $table->string('usage');
            $table->decimal('vehicle_value', 10, 2);
            $table->string('financial_interest')->nullable();
            $table->string('fuel_type');
            $table->string('name');
            $table->string('id_number');
            $table->string('location');
            $table->string('other_details');
            $table->text('vehicle_copy')->nullable();
            $table->text('id_copy')->nullable();
            $table->text('renewal_copy')->nullable();
            $table->text('vehical_pic')->nullable();
            $table->text('client_letter')->nullable();
            $table->text('other_doc')->nullable();
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
