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
        Schema::create('gas', function (Blueprint $table) {
            $table->id();
            $table->string('gas_type'); // ガスの種類
            $table->decimal('quantity', 10, 2); // 数量
            $table->date('date'); // 日付
            $table->string('prefecture'); // 入庫都道府県
            $table->enum('process', ['recovery', 'filling', 'refilling']); // ガス処理（回収、充填、再充填）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gas');
    }
};
