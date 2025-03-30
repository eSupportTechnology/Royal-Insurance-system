<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_response_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('form_field_id')->constrained()->onDelete('cascade');
            $table->text('response'); // The actual response from the user
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_response_fields');
    }
};
