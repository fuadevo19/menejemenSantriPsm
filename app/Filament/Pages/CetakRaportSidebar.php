<?php

namespace App\Filament\Pages;

use App\Models\Santri;
use App\Models\Semester;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Redirect;
use Filament\Notifications\Notification;


class CetakRaportSidebar extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static string $view = 'filament.pages.cetak-raport-sidebar';
    protected static ?string $title = 'Cetak Raport';

    public ?int $santri_id = null;
    public ?int $semester_id = null;

    protected function getFormSchema(): array
    {
        return [
            Select::make('santri_id')
        ->label('Nama Santri')
        ->options(
            Santri::query()
                ->whereNotNull('nama_santri')
                ->pluck('nama_santri', 'id')
                ->toArray()
        )
        ->searchable()
        ->required()
        ->default(request()->old('santri_id')),

    Select::make('semester_id')
        ->label('Semester')
        ->options(
            Semester::query()
                ->whereNotNull('nama_semester')
                ->pluck('nama_semester', 'id')
                ->toArray()
        )
        ->searchable()
        ->required()
        ->default(request()->old('semester_id')),
        ];
    }

    public function mount(): void
    {
        $this->santri_id = request()->query('santri_id');
        $this->semester_id = request()->query('semester_id');

        $this->form->fill([
            'santri_id' => $this->santri_id,
            'semester_id' => $this->semester_id,
        ]);
    }

    public function cetakCover()
    {
        if (!$this->santri_id) {
            Notification::make()
                ->title('Santri belum dipilih.')
                ->danger()
                ->send();
                
            return;
        }

        return Redirect::to('/cover/' . $this->santri_id);
        $this->dispatch('open-url', url: $url, newTab: true);
    }

    public function cetakDataDiri()
    {
        if (!$this->santri_id) {
            Notification::make()
                ->title('Santri belum dipilih.')
                ->danger()
                ->send();
            return;
        }

        return Redirect::to('/datadiri/' . $this->santri_id);
    }

    public function cetakRaport()
    {
        if (!$this->santri_id || !$this->semester_id) {
            Notification::make()
                ->title('Santri dan Semester wajib dipilih.')
                ->danger()
                ->send();
            return;
        }

        return Redirect::to('/raport/' . $this->santri_id . '/' . $this->semester_id);
    }

    public function cetakPengesahan()
    {
        if (!$this->santri_id || !$this->semester_id) {
            Notification::make()
                ->title('Santri dan Semester wajib dipilih.')
                ->danger()
                ->send();
            return;
        }

        return Redirect::to('/pengesahan/' . $this->santri_id . '/' . $this->semester_id);
    }


}
