<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newhris_menus', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Relasi ke menu induk (untuk dropdown bertingkat seperti Dokumen)
            $blueprint->foreignId('parent_id')->nullable()
                      ->constrained('newhris_menus')
                      ->onDelete('cascade');

            $blueprint->string('title'); // Contoh: Master Data, Daftar Pegawai
            $blueprint->string('key')->nullable(); // Untuk data-key="t-menu"
            $blueprint->string('icon')->nullable(); // Contoh: ri-stack-line
            $blueprint->string('url')->nullable(); // Contoh: route('hris.index') atau #sidebarMasterData
            
            // Untuk handling active state/collapse ID
            $blueprint->string('slug')->nullable(); // Contoh: master, pegawai/dokumen
            $blueprint->string('target_id')->nullable(); // ID untuk data-bs-target/collapse (e.g., sidebarMasterData)
            
            // Pengaturan urutan & tipe
            $blueprint->integer('order')->default(0);
            $blueprint->boolean('is_title')->default(false); // Untuk <li class="menu-title">
            $blueprint->boolean('is_active')->default(true);
            
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newhris_menus');
    }
};