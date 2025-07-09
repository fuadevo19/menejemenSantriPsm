<?php

namespace App\Filament\Resources;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\MataPelajaranResource\Pages;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Mata Pelajaran';
    protected static ?string $modelLabel = 'Mata Pelajaran';
    protected static ?string $pluralModelLabel = 'Data Mata Pelajaran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_pelajaran')
                ->label('Nama Pelajaran')
                ->required()
                ->afterStateUpdated(fn (callable $set, $state) =>
                    $set('nama_pelajaran', $state ? ucwords(strtolower($state)) : '')
                ),

            Select::make('kategori')
            ->label('Kategori')
            ->options([
                'Tertulis' => 'Tertulis',
                'Hafalan' => 'Hafalan',
                'Membaca' => 'Membaca',
                'Ekstrakulikuler' => 'Ekstrakulikuler',
            ])
            ->required()
            ->searchable(),

            Select::make('kelas_id')
                ->label('Kelas')
                ->relationship('kelas', 'nama_kelas')
                ->required(),

            Hidden::make('user_id')
                ->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('nama_pelajaran')->label('Pelajaran')->searchable(),
                TextColumn::make('kategori')->label('Kategori'),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('user.name')->label('Di input oleh'),
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
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }
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
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
