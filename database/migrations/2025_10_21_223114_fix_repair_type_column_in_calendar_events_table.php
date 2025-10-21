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
        // First, convert existing string data to JSON format
        $events = \DB::table('calendar_events')->whereNotNull('repair_type')->get();
        
        foreach ($events as $event) {
            // If repair_type is a string, convert it to JSON array
            if (is_string($event->repair_type)) {
                $repairTypeArray = [$event->repair_type]; // Convert single string to array
                \DB::table('calendar_events')
                    ->where('id', $event->id)
                    ->update(['repair_type' => json_encode($repairTypeArray)]);
            }
        }
        
        // Now change the column type
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->json('repair_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert JSON arrays back to strings (take first element)
        $events = \DB::table('calendar_events')->whereNotNull('repair_type')->get();
        
        foreach ($events as $event) {
            $repairTypeData = json_decode($event->repair_type, true);
            if (is_array($repairTypeData) && count($repairTypeData) > 0) {
                \DB::table('calendar_events')
                    ->where('id', $event->id)
                    ->update(['repair_type' => $repairTypeData[0]]); // Take first element
            }
        }
        
        // Revert column type
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->string('repair_type')->nullable()->change();
        });
    }
};
