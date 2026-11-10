<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponAssignment extends Model
{
    protected $with = ['weapon', 'owner', 'status'];
    
    protected $fillable = [
        'weapon_id',
        'owner_id',
        'assigned_by',
        'entry_date',
        'reason',
        'details',
        'status_id',
        'destination',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
    ];

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function status()
    {
        return $this->belongsTo(WeaponAssignmentStatus::class);
    }

    public function isActive()
    {
        return $this->status && $this->status->name === 'active';
    }

    public function isReturned()
    {
        return $this->status && $this->status->name === 'returned';
    }
}
