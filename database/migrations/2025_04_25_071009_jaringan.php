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
        Schema::create('jaringan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jaringan');
            $table->string('allowedRangeStart'); // Simpan IP dalam string
            $table->string('allowedRangeEnd');   // Simpan IP dalam string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jaringan');
    }
};
