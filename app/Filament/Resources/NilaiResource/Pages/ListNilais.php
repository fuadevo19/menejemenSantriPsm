<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListNilais extends ListRecords
{
    protected static string $resource = NilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {

        $tabs = [
            'semua' => Tab::make('Semua')
                
        ];

        // Hitung per kelas (exclude soft-deleted)
        $kelasList = \App\Models\Kelas::orderBy('nama_kelas', 'asc')
            ->get();

        foreach ($kelasList as $kelas) {
            $name = $kelas->nama_kelas;
            $slug = str($name)->slug()->toString();

            $tabs[$slug] = Tab::make($name)
                ->badge($kelas->santri_active_count) // pakai alias count yang sudah difilter
                ->modifyQueryUsing(function ($query) use ($kelas) {
                    // filter data tabel ke kelas itu saja; tampilannya tetap mengikuti query resource-mu
                    return $query->where('kelas_id', $kelas->id);
                });
        }

        return $tabs;
    }
}
