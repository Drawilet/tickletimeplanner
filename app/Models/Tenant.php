<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'background_image',
        'profile_image',
        'social_nets',
    ];

    protected $casts = [
        'social_nets' => 'array',
    ];
}
