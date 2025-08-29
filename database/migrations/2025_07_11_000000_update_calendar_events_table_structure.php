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
            // Add new fields for the calendar event form only if they don't exist
            if (!Schema::hasColumn('calendar_events', 'vehicle_info')) {
                $table->string('vehicle_info')->nullable()->comment('車両情報');
            }
            if (!Schema::hasColumn('calendar_events', 'repair_type')) {
                $table->string('repair_type')->nullable()->comment('修理の種類');
            }
            if (!Schema::hasColumn('calendar_events', 'workers')) {
                $table->json('workers')->nullable()->comment('作業員 (JSON array of worker names)');
            }
            if (!Schema::hasColumn('calendar_events', 'status')) {
                $table->enum('status', ['未開始', '進行中', '完了'])->default('未開始')->comment('ステータス');
            }
            if (!Schema::hasColumn('calendar_events', 'description')) {
                $table->text('description')->nullable()->comment('修理作業の詳細な説明');
            }
            if (!Schema::hasColumn('calendar_events', 'is_delayed')) {
                $table->boolean('is_delayed')->default(false)->comment('延期されたかどうか');
            }
            
            // Make end date nullable since it's optional in the form
            if (Schema::hasColumn('calendar_events', 'end')) {
                $table->date('end')->nullable()->change();
            }
            
            // Remove the old is_absent field as it's not used in the new form
            if (Schema::hasColumn('calendar_events', 'is_absent')) {
                $table->dropColumn('is_absent');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            // Remove new fields if they exist
            if (Schema::hasColumn('calendar_events', 'vehicle_info')) {
                $table->dropColumn('vehicle_info');
            }
            if (Schema::hasColumn('calendar_events', 'repair_type')) {
                $table->dropColumn('repair_type');
            }
            if (Schema::hasColumn('calendar_events', 'workers')) {
                $table->dropColumn('workers');
            }
            if (Schema::hasColumn('calendar_events', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('calendar_events', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('calendar_events', 'is_delayed')) {
                $table->dropColumn('is_delayed');
            }
            
            // Restore end date as required
            if (Schema::hasColumn('calendar_events', 'end')) {
                $table->date('end')->nullable(false)->change();
            }
            
            // Restore the old is_absent field
            if (!Schema::hasColumn('calendar_events', 'is_absent')) {
                $table->tinyInteger('is_absent')->nullable()->comment('欠席連絡かどうか: 1=欠席, 0=出席');
            }
        });
    }
};
