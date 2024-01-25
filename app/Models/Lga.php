<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'state_id',
        'zone_id',
        'description',
    ];

    public function users()
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

    public function wards()
    {
      return $this->hasMany(Ward::class);
    }

    public function pus()
    {
      return $this->hasMany(Pu::class);
    }
}
