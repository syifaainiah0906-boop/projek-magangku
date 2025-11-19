<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaData extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_data';

    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'angkatan',
        'user_id',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
