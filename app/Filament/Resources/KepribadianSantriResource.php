<?php

namespace App\Filament\Resources;

use App\Models\KepribadianSantri;
use App\Models\Santri;
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
use App\Filament\Resources\KepribadianSantriResource\Pages;

class KepribadianSantriResource extends Resource
{
    protected static ?string $model = KepribadianSantri::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';
    protected static ?string $navigationGroup = 'Manajemen Nilai & Absensi';
    protected static ?string $navigationLabel = 'Kepribadian Santri';
    protected static ?string $modelLabel = 'Kepribadian';
    protected static ?string $pluralModelLabel = 'Data Kepribadian';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('santri_id')
                ->label('Santri')
                ->relationship('santri', 'nama_santri')
                ->required(),

            Select::make('semester_id')                       // ⬅️ baru
                ->label('Semester')
                ->relationship('semester', 'nama_semester')
                ->required(),

            TextInput::make('akhlaq')
                ->label('Akhlaq')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),

            TextInput::make('kerajinan')
                ->label('Kerajinan')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),

            TextInput::make('kedisiplinan')
                ->label('Kedisiplinan')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),

            TextInput::make('kerapihan')
                ->label('Kerapihan')
                ->numeric()
                ->required()
                ->minValue(0)
                ->maxValue(100),

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri.nama_santri')->label('Santri')->searchable(),
                TextColumn::make('akhlaq')->label('Akhlaq'),
                TextColumn::make('kerajinan')->label('Kerajinan'),
                TextColumn::make('kedisiplinan')->label('Kedisiplinan'),
                TextColumn::make('kerapihan')->label('Kerapihan'),
                TextColumn::make('semester.nama_semester')->label('Semester'),
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
            'index'  => Pages\ListKepribadianSantris::route('/'),
            'create' => Pages\CreateKepribadianSantri::route('/create'),
            'edit'   => Pages\EditKepribadianSantri::route('/{record}/edit'),
        ];
    }
}
