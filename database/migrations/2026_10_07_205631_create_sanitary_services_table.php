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
        Schema::create('sanitary_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->default('plumbing');
            $table->text('short_description');
            $table->decimal('price', 8, 2);
            $table->boolean('price_is_from')->default(false);
            $table->string('price_note')->nullable();
            $table->string('duration_label')->nullable();
            $table->json('included_items')->nullable();
            $table->json('excluded_items')->nullable();
            $table->json('client_provides')->nullable();
            $table->text('extra_note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('robots')->default('index,follow');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanitary_services');
    }
};
