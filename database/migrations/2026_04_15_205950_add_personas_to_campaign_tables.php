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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->json('personas')->nullable()->after('status');
        });

        Schema::table('campaign_packages', function (Blueprint $table) {
            $table->string('persona')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('personas');
        });

        Schema::table('campaign_packages', function (Blueprint $table) {
            $table->dropColumn('persona');
        });
    }
};
