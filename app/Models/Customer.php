<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Base
{
    use HasFactory;
    protected $fillable = [
        "firstname",
        "lastname",
        "email",
        "phone",
        "address",
    ];
}
