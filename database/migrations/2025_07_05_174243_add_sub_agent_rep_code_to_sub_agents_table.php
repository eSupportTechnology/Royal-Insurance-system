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
        Schema::table('sub_agents', function (Blueprint $table) {
            $table->string('sub_agent_rep_code')->nullable()->after('agent_id');
        });
    }

    public function down(): void
    {
        Schema::table('sub_agents', function (Blueprint $table) {
            $table->dropColumn('sub_agent_rep_code');
        });
    }
};
