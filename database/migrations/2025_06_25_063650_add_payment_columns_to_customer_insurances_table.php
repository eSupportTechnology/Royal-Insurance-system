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
        Schema::table('customer_insurances', function (Blueprint $table) {
            $table->decimal('paid_amount', 15, 2)->required()->after('sum_insured');
            $table->decimal('outstanding_amount', 15, 2)->required()->after('paid_amount');
            $table->string('status')->required()->after('premium_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_insurances', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'outstanding_amount', 'status']);
        });
    }
};
