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
        Schema::create('blog_likes', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->morphs('likeable');   // likeable_id + likeable_type

        $table->timestamps();

        $table->unique(['user_id', 'likeable_id', 'likeable_type']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_likes');
    }
};
