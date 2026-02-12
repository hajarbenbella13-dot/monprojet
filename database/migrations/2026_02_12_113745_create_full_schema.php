<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --------------------------
        // Table userbackoffice
        // --------------------------
        Schema::create('userbackoffice', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100)->unique();
            $table->string('password', 255);
            $table->timestamps();
        });

        // --------------------------
        // Table lecteurs
        // --------------------------
        Schema::create('lecteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 150);
            $table->integer('age');
            $table->timestamps();
        });

        // --------------------------
        // Table livres
        // --------------------------
        Schema::create('livres', function (Blueprint $table) {
            $table->id();
            $table->string('titre', 255);
            $table->string('photo', 255)->nullable();
            $table->string('audio', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('userbackoffice')->onDelete('set null');
            $table->timestamps();
        });

        // --------------------------
        // Table pages
        // --------------------------
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livre_id')->constrained('livres')->onDelete('cascade');
            $table->integer('num_page');
            $table->string('image', 255)->nullable();
            $table->string('audio', 255)->nullable();
            $table->text('contenu')->nullable();
            $table->timestamps();
        });

        // --------------------------
        // Table progressions
        // --------------------------
        Schema::create('progressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecteur_id')->constrained('lecteurs')->onDelete('cascade');
            $table->foreignId('livre_id')->constrained('livres')->onDelete('cascade');
            $table->integer('derniere_page')->default(1);
            $table->timestamps();
            $table->unique(['lecteur_id', 'livre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progressions');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('livres');
        Schema::dropIfExists('lecteurs');
        Schema::dropIfExists('userbackoffice');
    }
};
