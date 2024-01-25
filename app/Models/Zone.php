<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

   protected $fillable = [
     'name',
     'state_id',
     'description',
   ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function lgas()
    {
        return $this->hasMany(Lga::class);
    }

    public function wards()
    {
        return $this->hasMany(Pu::class);
    }

    public function pus()
    {
        return $this->hasMany(Pu::class);
    }
}
