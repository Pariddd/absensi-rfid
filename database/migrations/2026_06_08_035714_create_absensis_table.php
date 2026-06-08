<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained('mahasiswas')
                ->onDelete('cascade');
            $table->string('uid', 20);
            $table->timestamp('waktu_scan');
            $table->timestamps();
            $table->index('waktu_scan');
            $table->index('mahasiswa_id');
        });
        DB::statement('ALTER TABLE absensis ADD UNIQUE KEY unique_absen_per_hari (mahasiswa_id, (DATE(waktu_scan)))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
