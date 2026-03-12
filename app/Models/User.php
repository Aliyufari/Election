<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HandleRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HandleRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'gender',
        'phone',
        'image',
        'company',
        'job',
        'country',
        'address',
        'role_id',
        'state_id',
        'zone_id',
        'lga_id',
        'ward_id',
        'pu_id',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'description',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
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

    public function pu()
    {
        return $this->belongsTo(Pu::class);
    }

    public function scopeVisibleTo($query, User $authUser)
    {
        if (!$authUser->hasAnyRole([
            'state_coordinator',
            'zonal_coordinator',
            'lga_coordinator',
            'ward_coordinator',
        ])) {
            return $query->whereRaw('1 = 0');
        }

        if ($authUser->state_id) {
            $query->where(function ($q) use ($authUser) {
                $q->where('state_id', $authUser->state_id)
                    ->orWhere('zone_id', $authUser->zone_id)
                    ->orWhere('lga_id', $authUser->lga_id)
                    ->orWhere('ward_id', $authUser->ward_id);
            });
        } elseif ($authUser->zone_id) {
            $query->where(function ($q) use ($authUser) {
                $q->where('zone_id', $authUser->zone_id)
                    ->orWhere('lga_id', $authUser->lga_id)
                    ->orWhere('ward_id', $authUser->ward_id);
            });
        } elseif ($authUser->lga_id) {
            $query->where(function ($q) use ($authUser) {
                $q->where('lga_id', $authUser->lga_id)
                    ->orWhere('ward_id', $authUser->ward_id);
            });
        } elseif ($authUser->ward_id) {
            $query->where('ward_id', $authUser->ward_id);
        } else {
            $query->whereRaw('1 = 0');
        }

        $query->whereHas('role', function ($q) use ($authUser) {
            if ($authUser->isStateCoordinator()) {
                $q->whereIn('name', ['zonal_coordinator', 'lga_coordinator', 'ward_coordinator']);
            } elseif ($authUser->isZonalCoordinator()) {
                $q->whereIn('name', ['lga_coordinator', 'ward_coordinator']);
            } elseif ($authUser->isLgaCoordinator()) {
                $q->where('name', 'ward_coordinator');
            } elseif ($authUser->isWardCoordinator()) {
                $q->where('name', 'ward_coordinator');
            }
        });

        return $query;
    }
}
