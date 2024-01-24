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
        'background_image',
        'profile_image',
        /*  'social_nets', */
    ];

    protected $casts = [
        /*       'social_nets' => 'array', */];
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
    public function spaces(){
        return $this->hasMany(Space::class);
    }
}
