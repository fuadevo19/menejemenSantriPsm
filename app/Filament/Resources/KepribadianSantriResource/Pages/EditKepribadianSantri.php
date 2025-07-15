<?php

namespace App\Filament\Resources\KepribadianSantriResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\KepribadianSantriResource;

class EditKepribadianSantri extends EditRecord
{
    protected static string $resource = KepribadianSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Tabel')
                ->url(\App\Filament\Resources\SantriResource::getUrl('index'))
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray'),
            Actions\DeleteAction::make(),
            
        ];
    }
}
