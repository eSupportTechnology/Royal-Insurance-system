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
            // Safely drop columns if they exist
            if (Schema::hasColumn('customer_insurances', 'rep')) {
                $table->dropColumn('rep');
            }

            if (Schema::hasColumn('customer_insurances', 'class')) {
                $table->dropColumn('class');
            }

            // Add new fields if they do not already exist
            if (!Schema::hasColumn('customer_insurances', 'insurance_type')) {
                $table->string('insurance_type')->required()->after('insurance_company');
            }

            if (!Schema::hasColumn('customer_insurances', 'category')) {
                $table->string('category')->nullable()->after('insurance_type');
            }

            if (!Schema::hasColumn('customer_insurances', 'subcategory')) {
                $table->string('subcategory')->nullable()->after('category');
            }

            if (!Schema::hasColumn('customer_insurances', 'varietyfields')) {
                $table->string('varietyfields')->nullable()->after('subcategory');
            }

            if (!Schema::hasColumn('customer_insurances', 'whatsapp')) {
                $table->string('whatsapp')->nullable()->after('contact');
            }

            if (!Schema::hasColumn('customer_insurances', 'subagent_code')) {
                $table->string('subagent_code')->nullable()->after('introducer_code');
            }

            if (!Schema::hasColumn('customer_insurances', 'premium_type')) {
                $table->string('premium_type')->required()->after('subagent_code');
            }
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_insurances', function (Blueprint $table) {
            // Re-add removed fields
            $table->string('rep')->nullable();
            $table->string('class')->nullable();

            // Drop newly added fields
            $table->dropColumn([
                'insurance_type',
                'category',
                'subcategory',
                'varietyfields',
                'whatsapp',
                'subagent_code',
                'premium_type',
            ]);
        });
    }
};
