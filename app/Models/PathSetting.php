<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PathSetting extends Model
{
    protected $fillable = [
        'code',
        'capacity',
        'is_active',
        'close_when_full',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'is_active' => 'boolean',
            'close_when_full' => 'boolean',
        ];
    }
}
