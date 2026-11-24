<?php

namespace App\Filament\Resources\Games\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('game_title')
                    ->label('Title')
                    ->required()
                    ->maxLength(100)
                    ->trim(),
                TextInput::make('slug')->maxLength(150)->trim(),
                TextInput::make('game_price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Select::make('categories')
                    ->relationship('categories', 'category_name')
                    ->multiple(),
                Select::make('tags')
                    ->relationship('tags', 'tag_name')
                    ->multiple(),
                DatePicker::make('release_date')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                TextInput::make('system_requirements')->required(),
                TextInput::make('developer_name')
                    ->label('Developer')
                    ->required()
                    ->maxLength(50)
                    ->trim(),
                TextInput::make('publisher_name')
                    ->label('Publisher')
                    ->required()
                    ->maxLength(50)
                    ->trim(),
                Toggle::make('is_active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true),
                FileUpload::make('cover_image_path')
                    ->label('Cover image')
                    ->directory('games/covers')
                    ->image()
                    ->maxSize(5120), // 5 MB
                FileUpload::make('game_file_path')
                    ->label('Game file')
                    ->directory('games/files')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                    ->maxSize(5120), // 5 MB
                Textarea::make('game_desc')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
