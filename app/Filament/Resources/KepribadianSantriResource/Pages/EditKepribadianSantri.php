<?php

namespace App\Filament\Resources\KepribadianSantriResource\Pages;

use App\Filament\Resources\KepribadianSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKepribadianSantri extends EditRecord
{
    protected static string $resource = KepribadianSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
