<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.username')
                    ->label('User'),
                TextEntry::make('game.game_title')
                    ->label('Game'),
                TextEntry::make('star')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->since()
                    ->isoDateTimeTooltip()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->since()
                    ->isoDateTimeTooltip()
                    ->placeholder('-'),
                TextEntry::make('body')
                    ->label('Review body')
                    ->placeholder('-')
                    ->columnSpanFull()
                    ->formatStateUsing(function (string $state) {
                        // Ganti em-dash atau hyphen yang dikelilingi spasi menjadi <br>
                        $formatted = str_replace(['—', ' - ', ' – '], '<br>', $state);

                        // Jika ada baris baru asli (\n) dari database, ubah juga menjadi <br>
                        return nl2br($formatted);
                    })
                    ->html(),
            ]);
    }
}
