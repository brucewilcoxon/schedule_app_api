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
        Schema::create('refrigerant_workplaces', function (Blueprint $table) {
            $table->id();
            $table->string('business')->comment('事業所(使用先)');
            $table->string('residence')->nullable()->comment('住所');
            $table->string('vehicle_registration_number')->nullable()->comment('車両登録番号');
            $table->string('serial_number')->nullable()->comment('シリアル番号');
            $table->string('machine_type')->nullable()->comment('機種');
            $table->string('gas_type')->nullable()->comment('機種/ガスタイプ');
            $table->decimal('initial_fill_amount', 8, 2)->nullable()->comment('初期充填量(kg)');
            $table->boolean('is_selected')->default(false)->comment('○を付ける');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refrigerant_workplaces');
    }
};
