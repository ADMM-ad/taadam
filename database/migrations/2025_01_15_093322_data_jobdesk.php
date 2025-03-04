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
        Schema::create('jobdesk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('team')->onDelete('cascade');
            $table->string('nama_pekerjaan');
            $table->text('deskripsi');
            $table->date('tenggat_waktu');
            $table->date('waktu_selesai')->nullable();
            $table->enum('status', ['ditugaskan', 'selesai']);
            $table->text('hasil')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_jobdesk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jobdesk_id')->constrained('jobdesk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobdesk');
        Schema::dropIfExists('detail_jobdesk');
    }
};
