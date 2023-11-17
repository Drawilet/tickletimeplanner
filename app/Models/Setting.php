<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ["name", "schedule", "opening", "closing"];

    protected $casts = [
        'schedule' => 'array',
    ];
}
