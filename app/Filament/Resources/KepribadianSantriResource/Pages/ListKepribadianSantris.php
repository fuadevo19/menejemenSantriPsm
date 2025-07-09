<?php

namespace App\Filament\Resources\KepribadianSantriResource\Pages;

use App\Filament\Resources\KepribadianSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKepribadianSantris extends ListRecords
{
    protected static string $resource = KepribadianSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
