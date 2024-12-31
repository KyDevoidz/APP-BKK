<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updating(function ($internship) {
            // Only update status if the current status is 'ongoing' and the end_date is today
            if ($internship->status === 'ongoing' && Carbon::today()->eq($internship->end_date)) {
                $internship->status = 'completed';
            }
        });
    }

    // Nama tabel di database (opsional jika nama tabel mengikuti konvensi jamak)

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'student_id', // Foreign key ke tabel students
        'company_name', // Nama perusahaan tempat prakerin
        'mentor_name',  // Nama pembimbing prakerin
        'start_date',   // Tanggal mulai prakerin
        'end_date',     // Tanggal selesai prakerin
        'status',       // Status prakerin (misalnya: selesai, berlangsung)
        'location',     // Lokasi prakerin
    ];

    /**
     * Relasi dengan model Student (banyak ke satu)
     * Setiap data prakerin terkait dengan seorang siswa.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}