<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Prompts\Key;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('reservation', function (Blueprint $table) {
            $table->integer('ref_evenement')->primary();
            $table->integer('ref_user')->primary();
            $table->foreign('ref_evenement')->references('id_evenement')->on('evenement');
            $table->foreign('ref_user')->references('id')->on('users');
        });

        Schema::create('role', function (Blueprint $table) {
            $table->integer('id_role')->primary();
            $table->string('libelle', 255)->nullable();
        });

        Schema::create('evenement', function (Blueprint $table) {
            $table->id_evenement()->primary();
            $table->string('titre', 45)->nullable();
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->integer('place', 1000);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
