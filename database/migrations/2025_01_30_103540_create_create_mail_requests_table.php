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
        Schema::create('mail_requests', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('company_email');
            $table->string('make');
            $table->integer('year');
            $table->string('vehicle_number');
            $table->string('usage');
            $table->decimal('vehicle_value', 10, 2);
            $table->string('financial_interest');
            $table->string('fuel_type');
            $table->string('customer_id');
            $table->string('email');
            $table->string('phone');
            $table->string('nic');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_mail_requests');
    }
};
