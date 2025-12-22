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
        // First, check if the table exists
        if (! Schema::hasTable('gas')) {
            return;
        }

        // Check if the process column exists
        if (! Schema::hasColumn('gas', 'process')) {
            return;
        }

        // Convert the enum column to VARCHAR to avoid enum modification issues
        // This is safer and more flexible
        Schema::table('gas', function (Blueprint $table) {
            $table->string('process', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('gas') || ! Schema::hasColumn('gas', 'process')) {
            return;
        }

        // Revert back to the original enum
        Schema::table('gas', function (Blueprint $table) {
            $table->enum('process', ['recovery', 'filling', 'refilling'])->change();
        });
    }
};
