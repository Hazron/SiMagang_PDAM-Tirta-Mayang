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
        Schema::create('logbook', function (Blueprint $table) {
            $table->id('id_logbook');
            $table->date('tanggal');
            $table->text('deskripsi_kegiatan');
            $table->string('dokumentasi')->nullable(); //file image
            $table->enum('status', ['menunggu persetujuan', 'disetujui'])->default('menunggu persetujuan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
