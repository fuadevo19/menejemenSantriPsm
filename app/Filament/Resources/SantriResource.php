<?php

namespace App\Filament\Resources;

use App\Models\Santri;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\SantriResource\Pages;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Santri';
    protected static ?string $modelLabel = 'Santri';
    protected static ?string $pluralModelLabel = 'Data Santri';

    public static function form(Form $form): Form
    {
        return $form->schema([
    TextInput::make('nama_santri')
        ->label('Nama Santri')
        ->required()
        ->afterStateUpdated(fn (callable $set, $state) =>
            $set('nama_santri', ucwords(strtolower($state)))
        ),

    TextInput::make('no_induk')
        ->label('Nomor Induk')
        ->required()
        ->unique(ignoreRecord: true),

    TextInput::make('alamat')
        ->label('Alamat')
        ->nullable()
        ->afterStateUpdated(fn (callable $set, $state) =>
            $set('alamat', ucwords(strtolower($state)))
        ),

    TextInput::make('angkatan')
        ->label('Angkatan')
        ->required()
        ->afterStateUpdated(fn (callable $set, $state) =>
            $set('angkatan', ucwords(strtolower($state)))
        ),

    Hidden::make('user_id')
        ->default(fn () => Auth::id())
        ->required(),

    Select::make('kelas_id')
        ->label('Kelas')
        ->relationship('kelas', 'nama_kelas')
        ->required(),
]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('no_induk')->label('No Induk')->searchable(),
                TextColumn::make('nama_santri')->label('Nama')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('alamat')->label('Alamat'),
                TextColumn::make('angkatan')->label('Angkatan'),
                TextColumn::make('user.name')->label('Di Input oleh'),
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
            'index' => Pages\ListSantris::route('/'),
            'create' => Pages\CreateSantri::route('/create'),
            'edit' => Pages\EditSantri::route('/{record}/edit'),
        ];
    }
}
