<?php

namespace App\Filament\Pages;

use App\Models\Santri;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Route;

class CetakRaport extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?int $santriId = null;
    public ?string $semester = null;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static string $view = 'filament.pages.cetak-raport';

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('santriId')
                ->label('Pilih Santri')
                ->options(Santri::all()->pluck('nama', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('semester')
                ->label('Semester')
                ->options([
                    '1_ganjil' => 'Semester 1 Ganjil',
                    '2_genap' => 'Semester 2 Genap',
                    // dst
                ])
                ->required(),
        ];
    }

    public function cetak()
    {
        return redirect()->route('preview.raport', [
            'santri' => $this->santriId,
            'semester' => $this->semester,
        ]);
    }
}
