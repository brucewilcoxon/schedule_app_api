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
        Schema::table('refrigerant_companies', function (Blueprint $table) {
            $table->string('owner')->nullable()->comment('所有者');
            $table->foreignId('manager_id')->nullable()->constrained('user_profiles')->onDelete('set null')->comment('管理者');
            $table->string('residence')->nullable()->comment('住所');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refrigerant_companies', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn(['owner', 'manager_id', 'residence']);
        });
    }
};
