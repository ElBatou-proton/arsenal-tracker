<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponAssignmentStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function weaponAssignments()
    {
        return $this->hasMany(WeaponAssignment::class);
    }
}
