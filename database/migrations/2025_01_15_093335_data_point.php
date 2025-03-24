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
        Schema::create('point_kpi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('detail_team_id')->constrained('detail_team')->onDelete('cascade');
            $table->foreignId('absensi_id')->constrained('absensi')->onDelete('cascade');
            $table->foreignId('jobdesk_id')->constrained('detail_jobdesk')->onDelete('cascade');
            $table->foreignId('jobdesk_hasil_id')->constrained('jobdesk_hasil')->onDelete('cascade');
            $table->date('bulan');
            $table->float('point_absensi');
            $table->float('point_jobdesk');
            $table->float('point_hasil');
            $table->float('point_attitude');
            $table->float('point_rata_rata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_kpi');
    }
};
