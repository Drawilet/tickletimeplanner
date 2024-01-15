<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpAdmin extends Model
{
    use HasFactory;
    protected $table = 'tenants';

    protected $fillable = [
      
    ];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
    
}

