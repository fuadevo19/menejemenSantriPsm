<?php

namespace App\Filament\Pages;

use App\Models\Santri;
use App\Models\Semester;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class CetakRaportSidebar extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static string $view = 'filament.pages.cetak-raport-sidebar';
    protected static ?string $title = 'Cetak Raport';

    public ?int $kelas_id = null;
    public ?int $semester_id = null;

    public array $santriList = [];

    protected function getFormSchema(): array
    {
        return [
            Select::make('kelas_id')
                ->label('Kelas')
                ->options(Kelas::pluck('nama_kelas', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantri()),

            Select::make('semester_id')
                ->label('Semester')
                ->options(Semester::pluck('nama_semester', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantri()),
        ];
    }

    public function loadSantri()
    {
        if ($this->kelas_id && $this->semester_id) {
            $this->santriList = Santri::where('kelas_id', $this->kelas_id)
                ->orderBy('nama_santri')
                ->get()
                ->toArray();
        } else {
            $this->santriList = [];
        }
    }

    /* ===========================
       ACTION CETAK (TAB BARU)
    ============================ */

    public function cetakCover($santriId)
    {
        $this->dispatch('open-new-tab', 
            url: url('/cover/' . $santriId)
        );
    }

    public function cetakDataDiri($santriId)
    {
        $this->dispatch('open-new-tab', 
            url: url('/datadiri/' . $santriId)
        );
    }

    public function cetakRaport($santriId)
    {
        if (!$this->semester_id) {
            Notification::make()
                ->title('Semester belum dipilih.')
                ->danger()
                ->send();
            return;
        }

        $this->dispatch('open-new-tab', 
            url: url('/raport/' . $santriId . '/' . $this->semester_id)
        );
    }

    public function cetakPengesahan($santriId)
    {
        if (!$this->semester_id) {
            Notification::make()
                ->title('Semester belum dipilih.')
                ->danger()
                ->send();
            return;
        }

        $this->dispatch('open-new-tab', 
            url: url('/pengesahan/' . $santriId . '/' . $this->semester_id)
        );
    }
}