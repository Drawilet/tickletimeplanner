<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Base
{
    use HasFactory;

    protected $fillable = [
        "event_id",
        "user_id",
        "amount",
        "concept",
        "notes",
    ];

}
