<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function scopeWithoutSuper(Builder $query): Builder
    {
        return $query->whereNotIn(
            DB::raw('LOWER(name)'),
            ['super']
        );
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
