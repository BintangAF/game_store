<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'username')
                    ->searchable(['username'])
                    ->required(),
                Select::make('game_id')
                    ->relationship('game', 'game_title')
                    ->searchable(['game_title'])
                    ->required(),
                TextInput::make('star')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),
                Textarea::make('body')
                    ->label('Review')
                    ->autosize()
                    ->minLength(5)
                    ->maxLength(1024)
                    ->default(null)
                    ->columnSpanFull()
                    ->trim(),
            ]);
    }
}
