<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "address",
        "city",
        "state",
        "country",
        "schedule",
    ];

    public function photos()
    {
        return $this->hasMany(SpacePhoto::class);
    }

    protected $casts = [
        'schedule' => 'array',
    ];
}
