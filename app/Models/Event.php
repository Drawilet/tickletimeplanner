<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Base
{
    use HasFactory;
    protected $fillable = ["name", "space_id", "customer_id", "date", "start_time", "end_time", "price", "notes"];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function products()
    {
        return $this->hasMany(EventProduct::class);
    }
}
