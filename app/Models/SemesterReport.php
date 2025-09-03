<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemesterReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester',
        'ip',
        'ipk',
        'khs_file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
