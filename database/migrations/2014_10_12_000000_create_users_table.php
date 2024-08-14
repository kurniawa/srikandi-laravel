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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('nik')->nullable()->unique();
            $table->string('nomor_wa')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['Developer', 'SuperAdmin', 'Admin', 'User', 'Client'])->default('Client');
            $table->smallInteger('clearance_level')->default(1);
            $table->string('gender', 20)->nullable(); // pria atau wanita
            $table->string('profile_picture_path')->nullable();
            $table->string('id_photo_path')->nullable();
            $table->string('created_by', 20)->nullable()->default("self"); // username dari auth user yang membuat
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
