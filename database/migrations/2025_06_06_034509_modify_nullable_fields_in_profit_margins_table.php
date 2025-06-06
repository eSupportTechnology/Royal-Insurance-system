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
        Schema::table('profit_margins', function (Blueprint $table) {
             $table->foreignId('category_id')->nullable()->change();
            $table->foreignId('sub_category_id')->nullable()->change();
            $table->foreignId('form_field_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profit_margins', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable(false)->change();
            $table->foreignId('sub_category_id')->nullable(false)->change();
            $table->foreignId('form_field_id')->nullable(false)->change();
        });
    }
};
