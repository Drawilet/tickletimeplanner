<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'suspended',
        'background_image',
        'profile_image',
        'plan_id',
        'next_plan_id',
        'subscription_ends_at',
        'balance'
    ];

    protected $casts = [
    ];
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function spaces()
    {
        return $this->hasMany(Space::class);
    }
    public function eventPayments()
    {
        return $this->hasMany(EventPayment::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function nextPlan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function transactions()
    {
        return $this->hasMany(TenantTransaction::class);
    }
}
