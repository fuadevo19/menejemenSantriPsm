<?php

namespace App\Filament\Resources;

use App\Models\Nilai;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MataPelajaran;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\NilaiResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon  = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Nilai & Absensi';
    protected static ?string $navigationLabel = 'Nilai Santri';
    protected static ?string $modelLabel      = 'Nilai';
    protected static ?string $pluralModelLabel = 'Data Nilai';

    /* ---------- Form ---------- */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('santri_id')
                ->label('Santri')
                ->relationship('santri', 'nama_santri')
                ->required(),

            Select::make('kelas_id')
    ->label('Kelas')
    ->relationship('kelas', 'nama_kelas')
    ->required()
    ->reactive(), // agar trigger perubahan saat dipilih

Select::make('mata_pelajaran_id')
    ->label('Mata Pelajaran')
    ->required()
    ->options(function (callable $get) {
        $kelasId = $get('kelas_id');

        if (!$kelasId) {
            return MataPelajaran::pluck('nama_pelajaran', 'id');
        }

        return MataPelajaran::where('kelas_id', $kelasId)->pluck('nama_pelajaran', 'id');
    })
    ->disabled(fn (callable $get) => !$get('kelas_id')) // matikan dulu sebelum kelas dipilih
    ->reactive(),

            Select::make('semester_id')
                ->label('Semester')
                ->relationship('semester', 'nama_semester')
                ->required(),

            Select::make('tahun_ajaran_id')
                ->label('Tahun Ajaran')
                ->relationship('tahunAjaran', 'label')
                ->required(),

            TextInput::make('nilai')
                ->label('Nilai')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),
                

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    /* ---------- Table ---------- */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri.nama_santri')->label('Santri')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('mataPelajaran.nama_pelajaran')->label('Pelajaran'),
                TextColumn::make('semester.nama_semester')->label('Semester'),
                TextColumn::make('tahunAjaran.label')->label('Tahun Ajaran'),
                TextColumn::make('nilai')->label('Nilai'),
                TextColumn::make('user.name')
                ->label('Diinput oleh')
                ->visible(fn () => Auth::user()?->role === 'super_admin'),
            ])
            ->filters([
                TrashedFilter::make(),
                
                SelectFilter::make('nama_semester')
                    ->label('semester')
                    ->relationship('semester', 'nama_semester'),
                SelectFilter::make('label')
                    ->label('Tahun Ajaran')
                    ->relationship('tahunAjaran', 'label'),
                
                ])
            ->actions([
                EditAction::make()
                    ->visible(fn ($record) => Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()),

                DeleteAction::make()
                    ->visible(fn ($record) => 
                        (Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()) 
                        && !$record->trashed()
                    ),

                RestoreAction::make()
                    ->visible(fn ($record) => 
                        (Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()) 
                        && $record->trashed()
                    ),

                ForceDeleteAction::make()
                    ->visible(fn ($record) => 
                        Auth::user()?->role === 'super_admin' && $record->trashed()
                    ),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->visible(fn () => Auth::user()?->role === 'super_admin'),
                RestoreBulkAction::make()
                    ->visible(fn () => Auth::user()?->role === 'super_admin'),
                ForceDeleteBulkAction::make()
                    ->visible(fn () => Auth::user()?->role === 'super_admin'),
            ]);
    }

    /* ---------- Query ---------- */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed();   // tampilkan juga data soft‑deleted
    }

    /* ---------- Auto‑set user_id ---------- */
    public static function beforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    public static function beforeSave(array $data): array
    {
        if (Auth::check() && Auth::user()->role !== 'super_admin') {
            $data['user_id'] = Auth::id();
        }
        return $data;
    }

    /* ---------- Pages ---------- */
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit'   => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
