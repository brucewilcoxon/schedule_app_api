<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the status column exists first
        if (Schema::hasColumn('calendar_events', 'status')) {
            // First, temporarily change the column to VARCHAR to allow any value
            DB::statement("ALTER TABLE calendar_events MODIFY COLUMN status VARCHAR(50) DEFAULT '未開始' COMMENT 'ステータス'");

            // Update any existing records with old status values
            DB::table('calendar_events')
                ->where('status', '進行中')
                ->update(['status' => '作業中']);

            // Then update the enum to include the new status values
            DB::statement("ALTER TABLE calendar_events MODIFY COLUMN status ENUM('未開始', '作業中', '見積り保留中', '部品待ち保留中', '完了', '連絡済み') DEFAULT '未開始' COMMENT 'ステータス'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE calendar_events MODIFY COLUMN status ENUM('未開始', '進行中', '完了') DEFAULT '未開始' COMMENT 'ステータス'");

        // Update any existing records that might have the new status values
        DB::table('calendar_events')
            ->where('status', '作業中')
            ->update(['status' => '進行中']);
    }
};
