<?php

namespace App\Filament\Resources\SemesterResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SemesterResource;

class CreateSemester extends CreateRecord
{
    protected static string $resource = SemesterResource::class;

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
