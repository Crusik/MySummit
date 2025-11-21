<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_name',
        'description',
        'test_type',
        'test_date',
        'results_received_date',
        'status',
        'result_value',
        'unit',
        'reference_range',
        'provider_notes',
        'file_path',
    ];

    protected $casts = [
        'test_date' => 'datetime',
        'results_received_date' => 'datetime',
    ];

    public function user()
    {
        return $this -> belongsTo(User::class);
    }
}
