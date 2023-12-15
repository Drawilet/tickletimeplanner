<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Base
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
        "color",
    ];

    public function photos()
    {
        return $this->hasMany(SpacePhoto::class);
    }

    protected $casts = [
        'schedule' => 'array',
    ];

    public function getAddress()
    {
        return $this->address . ", " . $this->city . ", " . $this->state . ", " . $this->country;
    }
}
