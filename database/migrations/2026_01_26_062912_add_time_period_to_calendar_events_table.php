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
        if (!Schema::hasColumn('calendar_events', 'time_period')) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->string('time_period')->nullable()->after('end')->comment('時間帯: 午前, 午後');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('calendar_events', 'time_period')) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->dropColumn('time_period');
            });
        }
    }
};
