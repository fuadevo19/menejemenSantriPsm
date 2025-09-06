<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Models\Santri;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TextFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;

use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use App\Filament\Resources\SantriResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Relations\HasOne;


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
         /* ---------- Identitas dasar ---------- */
            TextInput::make('nama_santri')
                ->label('Nama Santri')
                ->required()
                ->dehydrateStateUsing(fn ($state) => strtoupper($state)),

            TextInput::make('no_induk')
                ->label('Nomor Induk')
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('nisn')
                ->label('NISN')
                ->unique(ignoreRecord: true),

            /* ---------- Tambahan kolom baru ---------- */
            Select::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            TextInput::make('nik')
                ->label('NIK')
                ->unique(ignoreRecord: true)
                ->nullable(),

            TextInput::make('tempat_lahir')
                ->label('Tempat Lahir')
                ->nullable()
                ->afterStateUpdated(fn ($set,$state)=>
                    $set('tempat_lahir', ucwords(strtolower($state)))
                    ),

            DatePicker::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->nullable(),

            TextInput::make('agama')
                ->label('Agama')
                ->nullable()
                ->afterStateUpdated(fn ($set,$state)=>
                    $set('agama', ucwords(strtolower($state)))
                    ),
            
            TextInput::make('anak_ke')
                ->label('Anak Ke')
                ->numeric()
                ->minValue(1)
                ->nullable(),

            TextInput::make('sekolah_asal')
                ->label('Sekolah Asal')
                ->nullable()
                ->placeholder('Ex: SMA Taruna Utama'),
            
            TextInput::make('diterima_sebagai')
                ->label('Diterima Sebagai')
                ->nullable(),

            DatePicker::make('tanggal_diterima')
                ->label('Tanggal Diterima')
                ->nullable(),
                        
            /* ---------- Angkatan & Kelas ---------- */
            TextInput::make('angkatan')
                ->label('Angkatan')
                ->required(),

            Select::make('kelas_id')
                ->label('Kelas')
                ->relationship('kelas','nama_kelas')
                ->required(),

            TextInput::make('rombel')
                ->label('Rombel')
                ->nullable()
                ->afterStateUpdated(fn ($set,$state)=>
                        $set('rombel', ucwords(strtolower($state)))
                        ),

            Hidden::make('user_id')
                ->default(fn () => Auth::id())
                ->required(),

            Section::make('Alamat Santri')
                ->relationship('alamat')
                ->schema([
                    TextInput::make('dusun')->label('Dusun')->nullable(),
                    TextInput::make('desa')->label('Desa')->nullable()
                    ->afterStateUpdated(fn ($set,$state)=>
                        $set('desa', ucwords(strtolower($state)))
                        ),
                    TextInput::make('kecamatan')->label('Kecamatan')->nullable()
                    ->afterStateUpdated(fn ($set,$state)=>
                        $set('nama', ucwords(strtolower($state)))
                        ),
                    TextInput::make('kabupaten')->label('Kabupaten')->nullable()
                    ->afterStateUpdated(fn ($set,$state)=>
                        $set('nama', ucwords(strtolower($state)))
                         ),
                    TextInput::make('provinsi')->label('Provinsi')->nullable()
                    ->afterStateUpdated(fn ($set,$state)=>
                        $set('nama', ucwords(strtolower($state)))
                        ),
                    TextInput::make('kode_pos')->label('Kode Pos')->nullable(),
                ])
                ->columns(2),

            /* ---------- Data Ayah ---------- */
            Section::make('Data Ayah')
                    ->relationship('ayah')
                    ->schema([
                        Hidden::make('tipe')->default('ayah'),
                            TextInput::make('nama')->label('Nama Ayah')
                            ->afterStateUpdated(fn ($set,$state)=>
                                $set('nama', ucwords(strtolower($state)))
                            ),
                            TextInput::make('nik')->label('NIK Ayah')->maxLength(20),
                            TextInput::make('tahun_lahir')->label('Tahun Lahir')->numeric(),
                            TextInput::make('pendidikan')->label('Pendidikan'),
                            TextInput::make('pekerjaan')->label('Pekerjaan')
                            ->afterStateUpdated(fn ($set,$state)=>
                                $set('pekerjaan', ucwords(strtolower($state)))
                            ),
                            TextInput::make('penghasilan')->label('Penghasilan')->numeric(),
                            TextInput::make('email')->label('Email')->email(),
                            TextInput::make('telpon')->label('No Telpon'),
                        ])
                        ->inlineLabel(false)
                        ->columns(2),
                

            /* ---------- Data Ibu ---------- */
            Section::make('Data Ibu')
                    ->relationship('ibu')
                    ->schema([
                        Hidden::make('tipe')->default('ibu'),
                            TextInput::make('nama')->label('Nama Ibu')
                            ->afterStateUpdated(fn ($set,$state)=>
                                    $set('nama', ucwords(strtolower($state)))
                                ),
                            TextInput::make('nik')->label('NIK Ibu')->maxLength(20),
                            TextInput::make('tahun_lahir')->label('Tahun Lahir')->numeric(),
                            TextInput::make('pendidikan')->label('Pendidikan'),
                            TextInput::make('pekerjaan')->label('Pekerjaan')
                            ->afterStateUpdated(fn ($set,$state)=>
                                    $set('nama', ucwords(strtolower($state)))
                                ),
                            TextInput::make('penghasilan')->label('Penghasilan')->numeric(),
                            TextInput::make('email')->label('Email')->email(),
                            TextInput::make('telpon')->label('No Telpon'),
                        ])
                        ->inlineLabel(false)
                        ->columns(2),
                        
            
        ]);

                
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_induk')->label('No Induk')->searchable(),
                TextColumn::make('nisn')->label('NISN/NIS')->searchable(),
                TextColumn::make('nama_santri')->label('Nama')->searchable(),
                TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                TextColumn::make('angkatan')->label('Angkatan'),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->locale('id')->translatedFormat('d F Y')),
                TextColumn::make('ayah.nama')->label('Nama Ayah')->searchable()->toggleable(),
                TextColumn::make('ibu.nama')->label('Nama Ibu')->searchable()->toggleable(),
                TextColumn::make('alamat.desa')->label('Desa')->toggleable(),
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
