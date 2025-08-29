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
        Schema::table('calendar_events', function (Blueprint $table) {
            // Remove title and content columns
            if (Schema::hasColumn('calendar_events', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('calendar_events', 'content')) {
                $table->dropColumn('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            // Restore title and content columns
            if (!Schema::hasColumn('calendar_events', 'title')) {
                $table->string('title')->comment('イベントタイトル');
            }
            if (!Schema::hasColumn('calendar_events', 'content')) {
                $table->string('content')->nullable(true)->comment('イベント内容');
            }
        });
    }
};
