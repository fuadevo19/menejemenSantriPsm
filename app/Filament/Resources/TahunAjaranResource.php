<?php

namespace App\Filament\Resources;

use App\Models\TahunAjaran;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\TahunAjaranResource\Pages;

class TahunAjaranResource extends Resource
{
    protected static ?string $model = TahunAjaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Tahun Ajaran';
    protected static ?string $modelLabel = 'Tahun Ajaran';
    protected static ?string $pluralModelLabel = 'Data Tahun Ajaran';

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'super_admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('label')
                ->label('Label Tahun Ajaran')
                ->placeholder('contoh: 2024/2025')
                ->required(),

            TextInput::make('tahun_mulai')
                ->label('Tahun Mulai')
                ->numeric()
                ->minValue(2000)
                ->maxValue(2100)
                ->required(),

            TextInput::make('tahun_selesai')
                ->label('Tahun Selesai')
                ->numeric()
                ->minValue(2000)
                ->maxValue(2100)
                ->required(),

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('label')->label('Label')->searchable(),
                TextColumn::make('tahun_mulai')->label('Mulai'),
                TextColumn::make('tahun_selesai')->label('Selesai'),
                TextColumn::make('user.name')->label('Di input oleh'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function beforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTahunAjarans::route('/'),
            'create' => Pages\CreateTahunAjaran::route('/create'),
            'edit' => Pages\EditTahunAjaran::route('/{record}/edit'),
        ];
    }
}
