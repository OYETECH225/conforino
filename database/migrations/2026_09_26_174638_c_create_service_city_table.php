<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_city', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            // Paragraphe local unique injecte dans le template partagé service+ville
            // pour eviter le duplicate content entre les declinaisons.
            $table->text('local_intro')->nullable();
            $table->string('meta_title_override')->nullable();
            $table->string('meta_description_override')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['service_id', 'city_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_city');
    }
};
