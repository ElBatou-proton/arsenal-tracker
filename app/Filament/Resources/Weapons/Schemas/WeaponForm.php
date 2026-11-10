<?php

namespace App\Filament\Resources\Weapons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WeaponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('weapon_type_id')
                    ->label(__('weapons.weapon_type'))
                    ->relationship('weaponType', 'name')
                    ->required(),
                TextInput::make('brand')
                    ->label(__('weapons.brand')),
                TextInput::make('model')
                    ->label(__('weapons.model')),
                TextInput::make('caliber')
                    ->label(__('weapons.caliber')),
                TextInput::make('origin')
                    ->label(__('weapons.origin'))
                    ->required(),
                TextInput::make('chamber_length')
                    ->label(__('weapons.chamber_length')),
                Textarea::make('description')
                    ->label(__('weapons.description'))
                    ->columnSpanFull(),
                TextInput::make('serial_number')
                    ->label(__('weapons.serial_number'))
                    ->required()
                    ->unique(),
                TextInput::make('qr_code')
                    ->label(__('weapons.qr_code'))
                    ->default(function () {
                        return 'QR-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
                    })
                    ->helperText(__('weapons.qr_code_helper'))
                    ->unique()
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        // This will trigger the QR code preview update
                        $set('qr_code_preview', $state);
                    }),
                Placeholder::make('qr_code_preview')
                    ->label(__('weapons.qr_code_preview'))
                    ->content(function ($get) {
                        $qrValue = $get('qr_code') ?? '';
                        
                        if (!$qrValue) {
                            return new HtmlString('<div class="text-center p-4 bg-gray-50 rounded-lg"><div class="text-sm text-gray-600">Enter a QR code to see preview</div></div>');
                        }
                        
                        try {
                            // Try to generate QR code with different backends
                            $qrCodeImage = null;
                            
                            // First try with PNG format
                            try {
                                $qrCodeImage = QrCode::format('png')->size(200)->encoding('UTF-8')->errorCorrection('L')->generate($qrValue);
                            } catch (\Exception $e) {
                                // Fallback to SVG format if PNG fails
                                try {
                                    $qrCodeSvg = QrCode::format('svg')->size(200)->encoding('UTF-8')->errorCorrection('L')->generate($qrValue);
                                    return new HtmlString('
                                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                                            <div class="text-sm text-gray-600 mb-2">QR Code Preview</div>
                                            <div class="mx-auto border border-gray-300 rounded" style="max-width: 200px; height: auto;">' . $qrCodeSvg . '</div>
                                            <div class="text-xs text-gray-500 mt-2">' . e($qrValue) . '</div>
                                        </div>
                                    ');
                                } catch (\Exception $e2) {
                                    throw $e2; // Re-throw the original exception if both fail
                                }
                            }
                            
                            if ($qrCodeImage) {
                                $qrCodeBase64 = base64_encode($qrCodeImage);
                                
                                return new HtmlString('
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <div class="text-sm text-gray-600 mb-2">QR Code Preview</div>
                                        <img src="data:image/png;base64,' . $qrCodeBase64 . '" alt="QR Code" class="mx-auto border border-gray-300 rounded" style="max-width: 200px; height: auto;" />
                                        <div class="text-xs text-gray-500 mt-2">' . e($qrValue) . '</div>
                                    </div>
                                ');
                            }
                        } catch (\Exception $e) {
                            // Fallback to text display if QR generation fails
                            return new HtmlString('
                                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                    <div class="text-sm text-yellow-600 mb-2">QR Code (Preview Unavailable)</div>
                                    <div class="font-mono text-lg font-bold text-gray-700 bg-white p-3 rounded border">' . e($qrValue) . '</div>
                                    <div class="text-xs text-yellow-500 mt-2">QR code generation disabled: ' . e($e->getMessage()) . '</div>
                                </div>
                            ');
                        }
                    }),
                DatePicker::make('intake_date')
                    ->label(__('weapons.intake_date'))
                    ->required()
                    ->default(now()->format('Y-m-d')),
                TextInput::make('intake_time')
                    ->label(__('weapons.intake_time'))
                    ->type('time')
                    ->default(now()->format('H:i')),
                Select::make('owner_id')
                    ->label(__('weapons.owner'))
                    ->relationship('owner', 'last_name')
                    ->searchable()
                    ->nullable(),
            ]);
    }
}
