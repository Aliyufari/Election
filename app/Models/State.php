<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function lgas()
    {
        return $this->hasMany(Lga::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }

    public function pus()
    {
        return $this->hasMany(Pu::class);
    }
}
