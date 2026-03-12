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
        'created_by_id',
        'updated_by_id',
        'status',
    ];

    public function pu()
    {
        return $this->belongsTo(Pu::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public static function generateUniqueId(): string
    {
        do {
            $numbers = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $id = 'PRE' . $numbers;
        } while (self::where('unique_id', $id)->exists());

        return $id;
    }

    // app/Models/Cvr.php

    public function scopeVisibleTo($query, User $authUser)
    {
        return $query->with('pu.ward.lga.zone.state')
            ->when(
                $authUser->isStateCoordinator() && $authUser->state_id,
                fn($q) => $q->whereHas('pu', fn($q) => $q->where('state_id', $authUser->state_id))
            )
            ->when(
                $authUser->isZonalCoordinator() && $authUser->zone_id,
                fn($q) => $q->whereHas('pu', fn($q) => $q->where('zone_id', $authUser->zone_id))
            )
            ->when(
                $authUser->isLgaCoordinator() && $authUser->lga_id,
                fn($q) => $q->whereHas('pu', fn($q) => $q->where('lga_id', $authUser->lga_id))
            )
            ->when(
                $authUser->isWardCoordinator() && $authUser->ward_id,
                fn($q) => $q->whereHas('pu', fn($q) => $q->where('ward_id', $authUser->ward_id))
            );
    }
}
