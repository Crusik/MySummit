<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'month',
        'year',
        'systolic',
        'systolic_level',
        'diastolic',
        'diastolic_level',
        'respiratory_rate',
        'respiratory_level',
        'temperature',
        'temperature_level',
        'heart_rate',
        'heart_rate_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
