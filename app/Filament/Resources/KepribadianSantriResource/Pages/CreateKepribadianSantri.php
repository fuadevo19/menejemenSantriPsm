<?php

namespace App\Filament\Resources\KepribadianSantriResource\Pages;

use App\Filament\Resources\KepribadianSantriResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateKepribadianSantri extends CreateRecord
{
    protected static string $resource = KepribadianSantriResource::class;

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
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
{
    foreach ($data['data'] as $item) {

        \App\Models\KepribadianSantri::updateOrCreate(
            [
                'santri_id' => $item['santri_id'],
                'kelas_id' => $data['kelas_id'],
                'semester_id' => $data['semester_id'],
            ],
            [
                'akhlaq' => $item['akhlaq'],
                'kerajinan' => $item['kerajinan'],
                'kedisiplinan' => $item['kedisiplinan'],
                'kerapihan' => $item['kerapihan'],
                'user_id'  => Auth::id(),
            ]
        );
    }

    return new \App\Models\KepribadianSantri();
}

}
