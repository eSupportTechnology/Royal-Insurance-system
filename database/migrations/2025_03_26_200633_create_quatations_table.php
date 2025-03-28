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
        Schema::create('quatations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_company_id')->constrained('companies')->onDelete('cascade');
            $table->string('package_name');
            $table->enum('package_type', ['text', 'select', 'number', 'checkbox', 'file', 'date'])->default('text'); // Field types
            $table->boolean('required')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quatations');
    }
};
