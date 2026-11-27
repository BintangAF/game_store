<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required()
                    ->unique()
                    ->maxLength(40)
                    ->trim()->autofocus(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique()
                    ->trim(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable(),
                Select::make('role_id')
                ->relationship('role', 'role_name'),
            ]);
    }
}
