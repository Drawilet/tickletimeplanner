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
        "notes",
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

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
