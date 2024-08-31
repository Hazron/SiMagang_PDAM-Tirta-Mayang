<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id('id_logbook');
            $table->date('tanggal');
            $table->text('deskripsi_kegiatan');
            $table->string('dokumentasi')->nullable(); //file image, opsional
            $table->enum('status', ['menunggu persetujuan', 'disetujui'])->default('menunggu persetujuan');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
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
