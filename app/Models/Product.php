<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Base
{
    use HasFactory;
    protected $fillable = ["photo", "name", "description", "cost", "price", "notes"];

    public function events()
    {
        return $this->hasMany(EventProduct::class);
    }
}
