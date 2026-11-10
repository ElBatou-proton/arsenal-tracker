<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'rank_id',
    ];

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }

    public function weaponAssignments()
    {
        return $this->hasMany(WeaponAssignment::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameWithRankAttribute()
    {
        $rank = $this->rank ? $this->rank->abbreviation : '';
        return trim("{$rank} {$this->first_name} {$this->last_name}");
    }
}
