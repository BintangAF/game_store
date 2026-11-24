<?php

namespace App\Filament\Resources\Games\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
                TextInput::make('game_title')->required()->maxLength(100),
                TextInput::make('slug')->maxLength(150),
                TextInput::make('game_price')->required()->numeric()->prefix('Rp'),
                Textarea::make('game_desc')->required()->columnSpanFull(),
                FileUpload::make('cover_image_path')
                    ->directory('games/covers')
                    ->image()
                    ->maxSize(5120), // 5 MB
                FileUpload::make('game_file_path')
                    ->directory('games/files')
                    ->acceptedFileTypes(['application/zip', 'application/x-zip-compressed'])
                    ->maxSize(5120), // 5 MB
                DatePicker::make('release_date')->required()->native(false)->displayFormat('d/m/Y'),
                TextInput::make('system_requirements')->required(),
                TextInput::make('developer_name')->required()->maxLength(50),
                TextInput::make('publisher_name')->required()->maxLength(50),
                Toggle::make('is_active')->onColor('success')->offColor('danger')->default(true),
            ]);
    }
}
