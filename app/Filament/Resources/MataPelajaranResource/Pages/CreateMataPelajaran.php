<?php

namespace App\Filament\Resources\MataPelajaranResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\MataPelajaranResource;

class CreateMataPelajaran extends CreateRecord
{
    protected static string $resource = MataPelajaranResource::class;

     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(); // redirect ke halaman index 
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali ke Tabel')
                ->url(\App\Filament\Resources\SantriResource::getUrl('index'))
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray'),
        ];
    }
}
