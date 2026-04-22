<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caterer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('barangay')->nullable();
            $table->string('cuisine_type')->nullable();
            $table->integer('price_min')->nullable();
            $table->integer('price_max')->nullable();
            $table->integer('min_guests')->nullable();
            $table->integer('max_guests')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caterer_profiles');
    }
};
