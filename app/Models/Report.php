<?php

// app/Models/Report.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'nim',
        'prodi',
        'semester',
        'ip',
        'ipk',
        'khs_file',
    ];
    
    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}