<?php

namespace App\Filament\Resources;

use App\Models\Semester;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\SemesterResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Semester';
    protected static ?string $modelLabel = 'Semester';
    protected static ?string $pluralModelLabel = 'Data Semester';

    public static function canAccess(): bool
    {
        // ⛔️ Hanya Super Admin yang bisa akses menu ini
        return Auth::user()?->role === 'super_admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama_semester')
                ->label('Nama Semester')
                ->placeholder('Contoh: Semester 1')
                ->required(),

            Select::make('semester')
                ->label('Jenis Semester')
                ->options([
                    'Ganjil' => 'Ganjil',
                    'Genap' => 'Genap',
                ])
                ->required(),

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_semester')->label('Nama')->searchable(),
                TextColumn::make('semester')->label('Semester'),
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

    public static function beforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery(); // Tidak ada filter data, semua bisa melihat
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSemesters::route('/'),
            'create' => Pages\CreateSemester::route('/create'),
            'edit' => Pages\EditSemester::route('/{record}/edit'),
        ];
    }
}
