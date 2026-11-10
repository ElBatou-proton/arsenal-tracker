<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order',
    ];

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
}
