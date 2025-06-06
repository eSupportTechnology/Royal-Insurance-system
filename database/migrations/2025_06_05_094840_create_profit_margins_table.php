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
        Schema::create('profit_margins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('insurance_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('form_field_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('profit_type'); // RCC, TC, Net Premium
            $table->string('total');      // Storing first-row values
            $table->string('rib');
            $table->string('main_agent');
            $table->string('sub_agent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profit_margins');
    }
};
