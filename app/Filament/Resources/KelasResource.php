<?php

namespace App\Filament\Resources;

use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\KelasResource\Pages;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Kelas';
    protected static ?string $modelLabel = 'Kelas';
    protected static ?string $pluralModelLabel = 'Data Kelas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_kelas')
                ->label('Nama Kelas')
                ->required()
                ->afterStateUpdated(fn (callable $set, $state) =>
                    $set('nama_kelas', ucwords(strtolower($state)))
                ),

            Hidden::make('user_id')
                ->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('user.name')->label('Di Input oleh'),
                TextColumn::make('nama_kelas')->label('Nama Kelas')->searchable(),
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
