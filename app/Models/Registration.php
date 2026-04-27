<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'registration_number',
        'path_code',
        'full_name',
        'nisn',
        'nik',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'village',
        'district',
        'previous_school',
        'parent_name',
        'parent_phone',
        'email',
        'status',
        'admin_note',
        'submitted_at',
        'special_data',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'submitted_at' => 'datetime',
            'special_data' => 'array',
        ];
    }
}
