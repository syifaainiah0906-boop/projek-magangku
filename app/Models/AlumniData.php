<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniData extends Model
{
    use HasFactory;
    
    protected $table = 'alumni_data';

    protected $fillable = [
        'user_id',
        'graduation_year',
        'phone_number',
        'current_address',
        'employment_status',
        'company_name',
        'position',
        'work_address',
        'industry_field',
        'workplace_photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
