<?php

namespace App\Filament\Resources\SantriResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SantriResource;

class EditSantri extends EditRecord
{
    protected static string $resource = SantriResource::class;

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
