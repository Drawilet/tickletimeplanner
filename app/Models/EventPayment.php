<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPayment extends Base
{
    use HasFactory;

    protected $fillable = [
        "event_id",
        "amount",
        "notes",
    ];

}
