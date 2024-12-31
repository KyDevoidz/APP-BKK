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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Relasi ke tabel students
            $table->string('company_name'); // Nama perusahaan tempat prakerin
            $table->string('mentor_name');  // Nama pembimbing prakerin
            $table->string('location');     // Lokasi prakerin
            $table->date('start_date');     // Tanggal mulai prakerin
            $table->date('end_date');       // Tanggal selesai prakerin
            $table->enum('status', ['ongoing', 'completed', 'canceled'])->default('ongoing'); // Status prakerin
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};