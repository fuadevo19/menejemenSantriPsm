<?php

namespace App\Filament\Resources\NilaiResource\Pages;

use App\Filament\Resources\NilaiResource;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Santri;
use App\Models\Semester;
use App\Models\TahunAjaran;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BulkCreateNilai extends Page
{
    protected static string $resource = NilaiResource::class;
    protected static string $view = 'filament.resources.nilai-resource.pages.bulk-create-nilai';

    public $kelas_id;
    public $mata_pelajaran_id;
    public $semester_id;
    public $tahun_ajaran_id;
    public $santris = [];

    /* =======================
       AKSES
    ======================== */

    public static function canAccess(array $parameters = []): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin']);
    }

    /* =======================
       FORM
    ======================== */

    public function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('kelas_id')
                ->label('Kelas')
                ->options(Kelas::orderBy('nama_kelas')->pluck('nama_kelas', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantriWithNilai()),

            Forms\Components\Select::make('mata_pelajaran_id')
                ->label('Mata Pelajaran')
                ->options(fn () =>
                    $this->kelas_id
                        ? MataPelajaran::where('kelas_id', $this->kelas_id)
                            ->orderBy('nama_pelajaran')
                            ->pluck('nama_pelajaran', 'id')
                        : []
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantriWithNilai()),

            Forms\Components\Select::make('tahun_ajaran_id')
                ->label('Tahun Ajaran')
                ->options(
                    TahunAjaran::orderByDesc('tahun_mulai')
                        ->pluck('label', 'id')
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantriWithNilai()),

            Forms\Components\Select::make('semester_id')
                ->label('Semester')
                ->options(
                    Semester::orderBy('semester')
                        ->pluck('nama_semester', 'id')
                )
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->loadSantriWithNilai()),

            Forms\Components\Repeater::make('santris')
                ->label('Input Nilai Santri')
                ->schema([
                    Forms\Components\Hidden::make('santri_id'),

                    Forms\Components\TextInput::make('nama_santri')
                        ->disabled()
                        ->dehydrated(false),

                    Forms\Components\TextInput::make('nilai')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->placeholder('Masukkan Nilai'),
                ])
                ->columns(2)
                ->disableItemCreation()
                ->disableItemDeletion()
                ->reorderable(false),
        ]);
    }

    /* =======================
       LOAD NILAI LAMA
    ======================== */

    protected function loadSantriWithNilai()
    {
        if (! $this->kelas_id || ! $this->mata_pelajaran_id || ! $this->semester_id || ! $this->tahun_ajaran_id) {
            return;
        }

        $santriList = Santri::where('kelas_id', $this->kelas_id)
            ->orderBy('nama_santri')
            ->get();

        $existingNilai = Nilai::where('mata_pelajaran_id', $this->mata_pelajaran_id)
            ->where('semester_id', $this->semester_id)
            ->where('tahun_ajaran_id', $this->tahun_ajaran_id)
            ->whereIn('santri_id', $santriList->pluck('id'))
            ->get()
            ->keyBy('santri_id');

        $this->santris = $santriList->map(function ($santri) use ($existingNilai) {

            $nilai = $existingNilai[$santri->id]->nilai ?? null;

            return [
                'santri_id'   => $santri->id,
                'nama_santri' => $santri->nama_santri,
                'nilai'       => $nilai,
            ];
        })->toArray();
    }

    /* =======================
       ACTIONS
    ======================== */

    protected function getActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan / Update Nilai')
                ->action('save')
                ->color('primary'),

            Action::make('kembali')
                ->url(NilaiResource::getUrl())
                ->color('gray'),
        ];
    }

    /* =======================
       SAVE (UPSERT)
    ======================== */

    public function save()
    {
        DB::beginTransaction();

        try {

            foreach ($this->santris as $item) {

                if ($item['nilai'] === null || $item['nilai'] === '') {
                    continue;
                }

                Nilai::updateOrCreate(
                    [
                        'santri_id'         => $item['santri_id'],
                        'mata_pelajaran_id' => $this->mata_pelajaran_id,
                        'semester_id'       => $this->semester_id,
                        'tahun_ajaran_id'   => $this->tahun_ajaran_id,
                    ],
                    [
                        'kelas_id' => $this->kelas_id,
                        'nilai'    => $item['nilai'],
                        'user_id'  => Auth::id(),
                    ]
                );
            }

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollBack();

            Notification::make()
                ->title('Terjadi kesalahan')
                ->body($e->getMessage())
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Nilai berhasil disimpan / diperbarui')
            ->success()
            ->send();

        return redirect(NilaiResource::getUrl());
    }
}