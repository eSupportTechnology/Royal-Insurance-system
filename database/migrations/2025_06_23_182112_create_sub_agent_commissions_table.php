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
         Schema::create('sub_agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_insurance_id')->constrained()->onDelete('cascade');
            $table->string('sub_agent_rep_code')->nullable();
            $table->decimal('net_premium', 10, 2)->default(0);
            $table->decimal('srcc_premium', 10, 2)->default(0);
            $table->decimal('tc_premium', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_agent_commissions');
    }
};
