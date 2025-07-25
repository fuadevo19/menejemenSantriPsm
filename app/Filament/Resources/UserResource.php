<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Filament\Tables\Actions\ForceDeleteAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Admin User';
    protected static ?string $modelLabel = 'Admin User';
    protected static ?string $pluralModelLabel = 'Admin User';

   public static function canAccess(): bool
    {
    return Auth::user()?->role === 'super_admin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255)
                 ->afterStateUpdated(fn ($set,$state)=>
                    $set('name', ucwords(strtolower($state)))
                ),

            TextInput::make('username')
                ->label('Username')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('role')
                ->label('Peran')
                ->options([
                    'super_admin' => 'Super Admin',
                    'admin' => 'Admin',
                ])
                ->required(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->required(fn (string $context): bool => $context === 'create')
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
          return $table
        ->columns([
            TextColumn::make('name')->label('Nama')->searchable(),
            TextColumn::make('username')->label('Username')->searchable(),
            TextColumn::make('role')->label('Role')->badge(),
            TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y'),
        ])
        ->filters([
            TrashedFilter::make(), // 🔍 Filter tampilkan trashed (terhapus) / semua / aktif
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make()
                ->visible(fn ($record) => $record->id !== Auth::id()),

            // 🔁 Restore action jika record terhapus
            RestoreAction::make()
                ->visible(fn ($record) => $record->trashed()),

            // ❌ Force Delete (hapus permanen)
            ForceDeleteAction::make()
                ->visible(fn ($record) => $record->trashed()),
        ])
        ->bulkActions([
            DeleteBulkAction::make()->deselectRecordsAfterCompletion(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
