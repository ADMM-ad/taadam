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
        Schema::create('jobdesk_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('team')->onDelete('cascade');
            $table->string('bulan', 7);
            $table->string('views');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobdesk_hasil');
    }
};
