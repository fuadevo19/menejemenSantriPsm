<?php

namespace App\Filament\Resources\SantriResource\Pages;

use App\Filament\Resources\SantriResource;
use App\Models\Kelas;
use Filament\Actions;
use Filament\Resources\Components\Tab; // Page Tabs
use Filament\Resources\Pages\ListRecords;

class ListSantris extends ListRecords
{
    protected static string $resource = SantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    // Total aktif (exclude soft-deleted)
    $totalAktif = \App\Models\Santri::whereNull('deleted_at')->count();

    $tabs = [
        'semua' => Tab::make('Semua')
            ->badge($totalAktif),
    ];

    // Hitung per kelas (exclude soft-deleted)
    $kelasList = \App\Models\Kelas::orderBy('nama_kelas', 'asc')
        ->withCount([
            // sesuaikan nama relasi di model Kelas (santri / santris)
            'santris as santri_active_count' => function ($q) {
                $q->whereNull('deleted_at'); // tidak hitung yang di-soft delete
            },
        ])
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
