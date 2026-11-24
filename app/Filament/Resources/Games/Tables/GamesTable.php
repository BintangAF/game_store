<?php

namespace App\Filament\Resources\Games\Tables;

use App\Models\Game;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('game_title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('game_price')
                    ->label('Price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('categories.category_name'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->since()
                    ->isoDateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->since()
                    ->isoDateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', direction: 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('Activate')
                    ->action(function (Game $game) {
                        $game->is_active == true;
                        $game->save();
                    })
                    ->hidden(fn(Game $game): bool => $game->is_active),
                Action::make('Unactivate')
                    ->action(function (Game $game) {
                        $game->is_active == false;
                        $game->save();
                    })
                    ->visible(fn(Game $game): bool => $game->is_active),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
