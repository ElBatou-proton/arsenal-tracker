<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'name',
        'abbreviation',
        'order',
        'description',
    ];

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }
}
