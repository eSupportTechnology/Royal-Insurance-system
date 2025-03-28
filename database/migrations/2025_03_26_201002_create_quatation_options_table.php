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
        Schema::create('quatation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quatations')->onDelete('cascade'); // Reference correct table
    $table->string('option_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quatation_options');
    }
};
