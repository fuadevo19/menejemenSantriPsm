<?php

namespace App\Filament\Resources;

use App\Models\Absensi;
use App\Models\Santri;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\AbsensiResource\Pages;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Manajemen Nilai & Absensi';
    protected static ?string $navigationLabel = 'Absensi Santri';
    protected static ?string $modelLabel = 'Absensi';
    protected static ?string $pluralModelLabel = 'Data Absensi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('santri_id')
                ->label('Santri')
                ->relationship('santri', 'nama_santri')
                ->required(),

            TextInput::make('sakit')->numeric()->required()->default(0),
            TextInput::make('izin')->numeric()->required()->default(0),
            TextInput::make('alpha')->numeric()->required()->default(0),

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
                TextColumn::make('santri.nama_santri')->label('Santri')->searchable(),
                TextColumn::make('sakit')->label('Sakit'),
                TextColumn::make('izin')->label('Izin'),
                TextColumn::make('alpha')->label('Alpha'),
                TextColumn::make('user.name')->label('Diinput oleh'),
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
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
