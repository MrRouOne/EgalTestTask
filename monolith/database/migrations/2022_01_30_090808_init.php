<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_admin');
            $table->integer('points');
            $table->timestamps();
        });

        Schema::create('lottery_games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('gamer_count');
            $table->integer('reward_points');
            $table->timestamps();
        });

        Schema::create('lottery_game_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('lottery_games')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_date');
            $table->time('start_time');
            $table->foreignId('winner_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::create('lottery_game_match_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lottery_game_match_id')->constrained('lottery_game_matches')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('lottery_games');
        Schema::dropIfExists('lottery_game_matches');
        Schema::dropIfExists('lottery_game_match_users');
    }
}
