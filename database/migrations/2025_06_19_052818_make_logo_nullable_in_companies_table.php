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
         Schema::table('companies', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
            $table->string('address')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('contact_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('logo')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('contact_number')->nullable(false)->change();
        });
    }
};
