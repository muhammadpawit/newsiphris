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
        Schema::create('modul_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('modul_id'); // Sesuaikan nama kolom ID di tabel modul Anda

            // Foreign Key
            $table->foreign('role_id')->references('id')->on('newhris_roles')->onDelete('cascade');
            $table->foreign('modul_id')->references('id')->on('modul_aplikasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul_role');
    }
};
