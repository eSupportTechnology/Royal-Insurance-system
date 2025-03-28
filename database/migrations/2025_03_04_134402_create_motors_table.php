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
        $table->string('model');
        $table->year('year');
        $table->string('vehicle_number')->unique();
        $table->string('class');
        $table->string('usage');
        $table->decimal('vehicle_value', 10, 2);
        $table->string('financial_interest')->nullable();
        $table->string('fuel_type');

        // Store customer details instead of using a foreign key
        $table->unsignedBigInteger('customer_id');
        $table->string('email');
        $table->string('phone');
        $table->string('nic');
        $table->string('address');

        // Other optional details
        $table->text('other_details')->nullable();

        // Store file uploads as JSON (for multiple files)
        $table->json('vehicle_copy')->nullable();
        $table->json('id_copy')->nullable();
        $table->json('renewal_copy')->nullable();
        $table->json('vehical_pic')->nullable();
        $table->json('client_letter')->nullable();
        $table->json('other_doc')->nullable();

        $table->string('status')->default('Not send');
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
