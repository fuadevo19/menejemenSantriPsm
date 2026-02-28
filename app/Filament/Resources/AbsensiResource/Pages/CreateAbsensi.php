<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Filament\Resources\AbsensiResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;

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

        \App\Models\Absensi::updateOrCreate(
            [
                'santri_id' => $item['santri_id'],
                'kelas_id' => $data['kelas_id'],
                'semester_id' => $data['semester_id'],
            ],
            [
                'sakit' => $item['sakit'],
                'izin' => $item['izin'],
                'alpha' => $item['alpha'],
                'user_id'  => Auth::id(),
            ]
        );
    }

    return new \App\Models\Absensi();
}
}
