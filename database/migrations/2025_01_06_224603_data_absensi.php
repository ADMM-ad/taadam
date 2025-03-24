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
    Schema::create('absensi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->date('tanggal');
        $table->time('waktu_datang')->nullable();
        $table->time('waktu_terlambat')->nullable();
        $table->time('waktu_pulang')->nullable();
        $table->enum('kehadiran', ['datang', 'hadir', 'sakit', 'izin', 'tanpa_keterangan']);
        $table->string('pesan')->nullable();
        $table->string('bukti')->nullable();
        $table->enum('status', ['diproses','disetujui', 'ditolak']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
