<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pu extends Model
{
    use HasFactory;

    protected $fillable = [
     'number',
     'name',
     'state_id',
     'zone_id',
     'lga_id',
     'ward_id',
     'description',
     'accreditation',
     'registration',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function results()
    {
        return $this->hasMany(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
