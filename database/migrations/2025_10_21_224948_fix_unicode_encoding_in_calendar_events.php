<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix existing calendar events with Unicode escape sequences
        $calendarEvents = DB::table('calendar_events')->get();

        foreach ($calendarEvents as $event) {
            $updates = [];

            // Fix repair_type field
            if ($event->repair_type) {
                $repairType = $event->repair_type;
                // Check if it contains Unicode escape sequences
                if (strpos($repairType, '\\u') !== false) {
                    // Decode Unicode escape sequences and re-encode with JSON_UNESCAPED_UNICODE
                    $decoded = json_decode($repairType, true);
                    if ($decoded !== null) {
                        $updates['repair_type'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
                    }
                }
            }

            // Fix workers field
            if ($event->workers) {
                $workers = $event->workers;
                // Check if it contains Unicode escape sequences
                if (strpos($workers, '\\u') !== false) {
                    // Decode Unicode escape sequences and re-encode with JSON_UNESCAPED_UNICODE
                    $decoded = json_decode($workers, true);
                    if ($decoded !== null) {
                        $updates['workers'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
                    }
                }
            }

            // Update the record if there are changes
            if (! empty($updates)) {
                DB::table('calendar_events')
                    ->where('id', $event->id)
                    ->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not easily reversible as it fixes data corruption
        // The original Unicode escape sequences would need to be restored
        // which is not recommended
    }
};
