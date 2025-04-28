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
        Schema::create('customer_insurances', function (Blueprint $table) {
            $table->id();
            $table->string('inv');
            $table->date('date');
            $table->string('name');
            $table->string('policy')->nullable();
            $table->string('dn')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('class')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('rep')->nullable();
            $table->decimal('basic', 10, 2)->nullable();
            $table->decimal('srcc', 10, 2)->nullable()->default(0);
            $table->decimal('tc', 10, 2)->nullable()->default(0);
            $table->decimal('others', 10, 2)->nullable()->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('sum_insured', 15, 2)->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->string('introducer_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_insurances');
    }
};
