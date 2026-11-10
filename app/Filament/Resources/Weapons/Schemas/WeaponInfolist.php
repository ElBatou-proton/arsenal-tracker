<?php

namespace App\Filament\Resources\Weapons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Support\HtmlString;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Schemas\Schema;

class WeaponInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('weaponType.name')
                    ->label(__('weapons.weapon_type')),
                TextEntry::make('brand')
                    ->label(__('weapons.brand'))
                    ->placeholder('-'),
                TextEntry::make('model')
                    ->label(__('weapons.model'))
                    ->placeholder('-'),
                TextEntry::make('caliber')
                    ->label(__('weapons.caliber'))
                    ->placeholder('-'),
                TextEntry::make('origin')
                    ->label(__('weapons.origin'))
                    ->placeholder('-'),
                TextEntry::make('chamber_length')
                    ->label(__('weapons.chamber_length'))
                    ->placeholder('-'),
                TextEntry::make('serial_number')
                    ->label(__('weapons.serial_number')),
                TextEntry::make('qr_code')
                    ->label(__('weapons.qr_code_image'))
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $qrValue = $state;

                        if (!$qrValue) {
                            return '<div class="mb-4 text-center p-4 bg-gray-50 rounded-lg"><div class="text-sm text-gray-600">' . __('weapons.no_qr_code') . '</div></div>';
                        }

                        try {
                            
                            // Fallback to SVG if PNG fails
                            $qrCodeSvg = QrCode::format('svg')
                            ->size(300)
                            ->errorCorrection('H')
                            ->generate($qrValue);

                            $fileName = "qr-" . ($record->serial_number ?? 'code') . ".png";

                            return new HtmlString('
            <div class="mb-4 text-center p-4 bg-gray-50 rounded-lg flex flex-col items-center" 
                 x-data="{ 
                    downloadPng() {
                        const svg = $refs.qrSvg.querySelector(\'svg\');
                        const canvas = document.createElement(\'canvas\');
                        const ctx = canvas.getContext(\'2d\');
                        const loader = new Image();
                        
                        // Set dimensions + padding (e.g., 40px for border)
                        const padding = 40;
                        const size = 300;
                        canvas.width = size + (padding * 2);
                        canvas.height = size + (padding * 2);

                        loader.onload = () => {
                            // 1. Draw white background/border
                            ctx.fillStyle = \'white\';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            
                            // 2. Draw the QR code in the center
                            ctx.drawImage(loader, padding, padding, size, size);
                            
                            // 3. Trigger download
                            const link = document.createElement(\'a\');
                            link.download = \'' . $fileName . '\';
                            link.href = canvas.toDataURL(\'image/png\');
                            link.click();
                        };
                        
                        loader.src = \'data:image/svg+xml;base64,\' + btoa(new XMLSerializer().serializeToString(svg));
                    }
                 }">
                
                <div x-ref="qrSvg" class="p-2 bg-white border border-gray-300 rounded shadow-sm mb-4" style="max-width: 160px;">
                    ' . $qrCodeSvg . '
                </div>

                <div class="text-xs font-mono text-gray-500 mb-4">' . e($qrValue) . '</div>

                <button type="button" 
                        x-on:click="downloadPng"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg shadow hover:bg-primary-500">
                    ' . __('weapons.qr_code_image_save') . '
                </button>
            </div>
        ');
                        } catch (\Exception $e) {
                            return new HtmlString('<div class="p-4 bg-red-50 text-red-600 rounded">Error: ' . e($e->getMessage()) . '</div>');
                        }
                    })
                    ->columnSpanFull(),
                TextEntry::make('intake_date')
                    ->label(__('weapons.intake_date'))
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('intake_time')
                    ->label(__('weapons.intake_time'))
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('owner.first_name')
                    ->label(__('weapons.owner'))
                    ->formatStateUsing(fn($record) => $record->owner ? "{$record->owner->first_name} {$record->owner->last_name}" : '-')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->label(__('weapons.description'))
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
