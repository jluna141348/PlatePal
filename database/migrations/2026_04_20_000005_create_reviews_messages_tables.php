<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caterer_profile_id')->constrained('caterer_profiles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->string('event_type')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('body');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('saved_caterers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('caterer_profile_id')->constrained('caterer_profiles')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['user_id', 'caterer_profile_id']);
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caterer_profile_id')->constrained('caterer_profiles')->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('saved_caterers');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('reviews');
    }
};
