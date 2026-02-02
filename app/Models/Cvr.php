<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cvr extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'type',
        'pu_id',
        'user_id',
        'status',
    ];

    public function pu()
    {
        return $this->belongsTo(Pu::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Pu::class);
    }

    public static function generateUniqueId(): string
    {
        do {
            $letters = '';
            for ($i = 0; $i < 3; $i++) {
                $letters .= chr(rand(65, 90));
            }

            $numbers = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $id = $letters . $numbers;
        } while (self::where('unique_id', $id)->exists());

        return $id;
    }
}
