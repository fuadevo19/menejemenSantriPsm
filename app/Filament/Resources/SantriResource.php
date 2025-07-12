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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\SantriResource\Pages;

use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TextFilter;

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

            TextInput::make('NISN/NIS')
                ->label('NISN/NIS')
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
        return $table
            ->columns([
                TextColumn::make('no_induk')->label('No Induk')->searchable(),
                TextColumn::make('NISN/NIS')->label('NISN/NIS')->searchable(),
                TextColumn::make('nama_santri')->label('Nama')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('alamat')->label('Alamat'),
                TextColumn::make('angkatan')->label('Angkatan'),
                TextColumn::make('user.name')
                ->label('Diinput oleh')
                ->visible(fn () => Auth::user()?->role === 'super_admin'),
            ])
            ->filters([
                TrashedFilter::make(),
                
                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->relationship('kelas', 'nama_kelas'),

                SelectFilter::make('angkatan')
                    ->label('Angkatan')
                    ->options(
                        Santri::select('angkatan')
                            ->distinct()
                            ->pluck('angkatan', 'angkatan')
                            ->toArray()
                    ),
                ])
            ->actions([
                EditAction::make()
                    ->visible(fn ($record) => Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()),

                DeleteAction::make()
                    ->visible(fn ($record) => Auth::user()?->role === 'super_admin' || $record->user_id === Auth::id()),

                RestoreAction::make()
                    ->visible(fn ($record) => Auth::user()?->role === 'super_admin' && $record->trashed()),

                ForceDeleteAction::make()
                    ->visible(fn ($record) => Auth::user()?->role === 'super_admin' && $record->trashed()),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed(); // tampilkan semua data termasuk terhapus
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
            'index' => Pages\ListSantris::route('/'),
            'create' => Pages\CreateSantri::route('/create'),
            'edit' => Pages\EditSantri::route('/{record}/edit'),
        ];
    }
}
