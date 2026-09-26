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
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('text');
            $table->string('author_name');
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->string('city_label')->nullable();
            $table->date('review_date')->nullable();
            $table->enum('source', ['google', 'site'])->default('site');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
