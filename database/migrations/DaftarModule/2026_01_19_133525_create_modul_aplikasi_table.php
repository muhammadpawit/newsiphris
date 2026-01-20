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
        Schema::create('modul_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->unique();
            $table->string('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('url')->nullable();
            $table->enum('status',['development','active','inactive'])->default('inactive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_aplikasi');
    }
};
