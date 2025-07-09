<?php

namespace App\Filament\Resources;

use App\Models\Nilai;
use App\Models\Santri;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\NilaiResource\Pages;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Manajemen Nilai & Absensi';
    protected static ?string $navigationLabel = 'Nilai Santri';
    protected static ?string $modelLabel = 'Nilai';
    protected static ?string $pluralModelLabel = 'Data Nilai';

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
                ->required(),

            Select::make('mata_pelajaran_id')
                ->label('Mata Pelajaran')
                ->relationship('mataPelajaran', 'nama_pelajaran')
                ->required(),

            TextInput::make('nilai')
                ->label('Nilai')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),

                TextInput::make('jumlah_terbilang')
                ->label('Jumlah Terbilang')
                ->required()
                ->maxLength(255),

                Select::make('semester_id')
                ->label('Semester')
                ->relationship('semester', 'nama_semester')
                ->required(),

                Select::make('tahun_ajaran_id')
                ->label('Tahun Ajaran')
                ->relationship('tahunAjaran', 'label') // Pastikan relasi di model benar
                ->required(),

                Hidden::make('user_id')->default(fn () => Auth::id()),
                ]);
            }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('santri.nama_santri')->label('Santri')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('mataPelajaran.nama_pelajaran')->label('Pelajaran'),
                TextColumn::make('semester.nama_semester')->label('Semester'),
                TextColumn::make('tahunAjaran.label')->label('Tahun Ajaran'),
                TextColumn::make('nilai')->label('Nilai'),
                TextColumn::make('jumlah_terbilang')->label('Terbilang'),
                TextColumn::make('user.name')->label('Diinput Oleh'),
            ])
            ->actions([
                EditAction::make()->visible(fn ($record) => Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()),
                DeleteAction::make()->visible(fn ($record) => Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (Auth::check() && Auth::user()->role !== 'super_admin') {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }

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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
