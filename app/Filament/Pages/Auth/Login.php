<?php

namespace App\Filament\Pages\Auth;

use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getUsernameFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    // ✅ Custom pesan error agar muncul tepat di bawah field
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => 'Username atau password salah.',
        ]);
    }

    protected function getRememberFormComponent(): Component
{
    return Checkbox::make('remember')
        ->label('Ingat saya')
        ->extraInputAttributes(['tabindex' => 3]);
}

public function getTanggalDiterimaFormattedAttribute()
{
    if (! $this->tanggal_diterima) {
        return null;
    }

    return Carbon::parse($this->tanggal_diterima)
        ->locale('id')
        ->translatedFormat('j F Y'); // contoh: 1 Juli 2025
}
                                           
}
