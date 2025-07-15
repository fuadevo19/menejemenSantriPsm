<?php

namespace App\Filament\Resources;

use App\Models\MataPelajaran;
use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
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

            TextInput::make('nama_pelajaran_arab')
                ->label('Nama Arab Pelajaran')
                ->extraAttributes([
                    'dir'  => 'rtl',      // tulis dari kanan ke kiri
                    'lang' => 'ar',       // beri tahu browser ini bahasa Arab
                    'inputmode' => 'verbatim', // keyboard huruf penuh, bukan angka
                ])
                ->placeholder('فقه المبادئ'),

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

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_pelajaran')->label('Pelajaran')->searchable(),
                TextColumn::make('kategori')->label('Kategori'),
                TextColumn::make('nama_pelajaran_arab')->label('Nama Arab Pelajaran'),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('user.name')
                ->label('Diinput oleh')
                ->visible(fn () => Auth::user()?->role === 'super_admin'),
            ])
            ->filters([
                TrashedFilter::make(),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->withTrashed();
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
            'index'  => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit'   => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
