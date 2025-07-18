<?php

namespace App\Filament\Resources\SantriResource\Pages;

use App\Filament\Resources\SantriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSantri extends CreateRecord
{
    protected static string $resource = SantriResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(); // redirect ke halaman index 
    }
}