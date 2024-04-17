<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "tenant_id",
        "amount",
        "notes",
        "reference"
    ];
}
