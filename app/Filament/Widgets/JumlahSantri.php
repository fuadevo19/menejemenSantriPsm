<?php

namespace App\Filament\Widgets;

use App\Models\Santri;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class JumlahSantri extends BaseWidget
{
    
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        $totalSantri = Santri::count();
        $santriPutra = Santri::where('jenis_kelamin', 'L')->count();
        $santriPutri = Santri::where('jenis_kelamin', 'P')->count();

        return [
            Card::make('Total Santri', $totalSantri)
                ->description('Keseluruhan')
                ->color('success'),

            Card::make('Santri Putra', $santriPutra)
                ->description('Laki-laki')
                ->color('info'),

            Card::make('Santri Putri', $santriPutri)
                ->description('Perempuan')
                ->color('danger'),
        ];
    }
}
