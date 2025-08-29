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
        Schema::create('refrigerant_companies', function (Blueprint $table) {
            $table->id();
            $table->string('item')->comment('項目');
            $table->enum('process_type', ['collection', 'filling', 'collection_filling'])->comment('回収・充填・回収充填');
            $table->date('delivery_date')->comment('交付年月日');
            $table->boolean('is_selected')->default(false)->comment('○を付ける');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refrigerant_companies');
    }
}; 