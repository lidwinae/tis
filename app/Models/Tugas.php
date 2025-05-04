<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';
    
    protected $fillable = [
        'dosen_id',
        'judul',
        'deskripsi',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'datetime'
    ];

    // Relasi ke User (Dosen)
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    // Relasi ke Jawaban (One to Many)
    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }
}