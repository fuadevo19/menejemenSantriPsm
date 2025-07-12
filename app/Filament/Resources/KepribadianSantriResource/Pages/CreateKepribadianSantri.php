<?php

namespace App\Filament\Resources\KepribadianSantriResource\Pages;

use App\Filament\Resources\KepribadianSantriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKepribadianSantri extends CreateRecord
{
    protected static string $resource = KepribadianSantriResource::class;

     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(); // redirect ke halaman index 
    }

}
