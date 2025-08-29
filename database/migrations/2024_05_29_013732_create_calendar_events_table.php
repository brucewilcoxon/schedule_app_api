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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title')->comment('イベントタイトル');
            $table->string('content')->nullable(true)->comment('イベント内容');
            $table->date('start')->comment('開始日時');
            $table->date('end')->comment('終了日時');
            $table->tinyInteger('is_absent')->nullable(true)->comment('欠席連絡かどうか: 1=欠席, 0=出席');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
