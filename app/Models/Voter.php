<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_phase_figure',
        'second_phase_figure',
        'ward_id',
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
