<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
     'pu_id',
     'election_id',
     'image',
    ];

    public function pu()
    {
        return $this->belongsTo(Pu::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
