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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name')->nullable()->comment('ユーザ名');
            $table->string('gender')->nullable()->comment('性別');
            $table->string('age')->nullable()->comment('年齢');
            $table->string('introduction')->nullable(true)->comment('自己紹介文');
            $table->string('profile_image')->nullable(true)->comment('プロフィール画像');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
