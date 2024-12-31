<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Internship; // Tambahkan ini untuk mendefinisikan relasi

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nisn',
        'no_hp',
        'walas',
        'kelas',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}