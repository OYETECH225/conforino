<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Les blocs étaient limités aux Pages (page_id). Pour rendre éditables les
     * sections bespoke des Services (corps de métier, normes PMR...) et de la
     * page Réalisations via le même constructeur de blocs, la table passe en
     * relation polymorphique (blockable_type / blockable_id).
     *
     * SQLite refuse de DROP une colonne portant une clé étrangère (même avec
     * PRAGMA foreign_keys=OFF) : on reconstruit la table plutôt que de tenter
     * un ALTER COLUMN, ce qui reste portable vers MySQL en production.
     */
    public function up(): void
    {
        Schema::rename('blocks', 'blocks_old');

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('blockable_type');
            $table->unsignedBigInteger('blockable_id');
            $table->string('type');
            $table->json('data')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['blockable_type', 'blockable_id', 'order']);
        });

        $rows = DB::table('blocks_old')->get();

        foreach ($rows as $row) {
            DB::table('blocks')->insert([
                'id' => $row->id,
                'blockable_type' => \App\Models\Page::class,
                'blockable_id' => $row->page_id,
                'type' => $row->type,
                'data' => $row->data,
                'order' => $row->order,
                'is_active' => $row->is_active,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        Schema::drop('blocks_old');
    }

    public function down(): void
    {
        Schema::rename('blocks', 'blocks_new');

        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->json('data')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['page_id', 'order']);
        });

        $rows = DB::table('blocks_new')->where('blockable_type', \App\Models\Page::class)->get();

        foreach ($rows as $row) {
            DB::table('blocks')->insert([
                'id' => $row->id,
                'page_id' => $row->blockable_id,
                'type' => $row->type,
                'data' => $row->data,
                'order' => $row->order,
                'is_active' => $row->is_active,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        Schema::drop('blocks_new');
    }
};
