<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Weapon extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'weapon_type_id',
        'brand',
        'model',
        'caliber',
        'origin',
        'chamber_length',
        'description',
        'serial_number',
        'qr_code',
        'intake_date',
        'intake_time',
        'owner_id',
    ];

    protected $casts = [
        'intake_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function weaponType()
    {
        return $this->belongsTo(WeaponType::class);
    }

    public function weaponAssignments()
    {
        return $this->hasMany(WeaponAssignment::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($weapon) {
            if (empty($weapon->intake_date)) {
                $weapon->intake_date = now()->format('Y-m-d');
            }
            if (empty($weapon->intake_time)) {
                $weapon->intake_time = now()->format('H:i');
            }
            // Generate QR code if not provided
            if (empty($weapon->qr_code)) {
                $weapon->qr_code = 'QR-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
            }
        });
    }

    public static function generateQrCode()
    {
        return 'QR-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }

    public function getQrCodeImageAttribute()
    {
        if ($this->qr_code) {
            return QrCode::format('png')->size(200)->generate($this->qr_code);
        }
        return null;
    }

    public function getQrCodeSvgAttribute()
    {
        if ($this->qr_code) {
            return QrCode::format('svg')->size(200)->generate($this->qr_code);
        }
        return null;
    }

    public function currentAssignment()
    {
        return $this->weaponAssignments()->where('status_id', function($query) {
            $query->select('id')
                ->from('weapon_assignment_statuses')
                ->where('name', 'active');
        })->first();
    }

    public function isCurrentlyAssigned()
    {
        return $this->currentAssignment() !== null;
    }
}
