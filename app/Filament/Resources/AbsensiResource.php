<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

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

    Select::make('kelas_id')
        ->label('Kelas')
        ->relationship('kelas', 'nama_kelas')
        ->reactive()
        ->required()
        ->afterStateUpdated(function ($state, callable $get, callable $set) {

            if ($state && $get('semester_id')) {

                $santris = \App\Models\Santri::where('kelas_id', $state)->get();

                $data = $santris->map(function ($santri) use ($get, $state) {

                    $existing = \App\Models\Absensi::where([
                        'santri_id' => $santri->id,
                        'kelas_id' => $state,
                        'semester_id' => $get('semester_id'),
                    ])->first();

                    return [
                        'santri_id' => $santri->id,
                        'nama_santri' => $santri->nama_santri,
                        'sakit' => $existing?->sakit ?? 0,
                        'izin' => $existing?->izin ?? 0,
                        'alpha' => $existing?->alpha ?? 0,
                    ];
                })->toArray();

                $set('data', $data);
            }
        }),

    Select::make('semester_id')
        ->label('Semester')
        ->relationship('semester', 'nama_semester')
        ->reactive()
        ->required()
        ->afterStateUpdated(function ($state, callable $get, callable $set) {

            if ($state && $get('kelas_id')) {

                $santris = \App\Models\Santri::where('kelas_id', $get('kelas_id'))->get();

                $data = $santris->map(function ($santri) use ($get, $state) {

                    $existing = \App\Models\Absensi::where([
                        'santri_id' => $santri->id,
                        'kelas_id' => $get('kelas_id'),
                        'semester_id' => $state,
                    ])->first();

                    return [
                        'santri_id' => $santri->id,
                        'nama_santri' => $santri->nama_santri,
                        'sakit' => $existing?->sakit ?? 0,
                        'izin' => $existing?->izin ?? 0,
                        'alpha' => $existing?->alpha ?? 0,
                    ];
                })->toArray();

                $set('data', $data);
            }
        }),

                Repeater::make('data')
                ->label('Data Absensi')
                ->schema([

                    Hidden::make('santri_id'),

                    TextInput::make('nama_santri')
                        ->label('Santri')
                        ->disabled()
                        ->columnSpanFull(),

                    TextInput::make('sakit')
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('izin')
                        ->numeric()
                        ->minValue(0)
                        ->default(0),

                    TextInput::make('alpha')
                        ->numeric()
                        ->minValue(0)
                        ->default(0),
                ])
                ->columns(3)
                ->disableItemCreation()
                ->disableItemDeletion()
                ->columnSpanFull(),

            Hidden::make('user_id')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('santri.nama_santri')->label('Santri')->searchable(),
                TextColumn::make('sakit')->label('Sakit'),
                TextColumn::make('izin')->label('Izin'),
                TextColumn::make('alpha')->label('Alpha'),
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
        return parent::getEloquentQuery()
            ->whereHas('santri') // hanya ambil yang santrinya tidak di-soft delete
            ->with(['santri', 'semester', 'user']);
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
