<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester',
        'activity_date',
        'activity_name',
        'position',
        'description',
        'photo_file_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
