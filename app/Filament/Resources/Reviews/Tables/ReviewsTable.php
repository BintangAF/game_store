<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Slider;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.username')
                    ->searchable(),
                TextColumn::make('game.game_title')
                    ->searchable(),
                TextColumn::make('star')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('body')
                    ->label('Review')
                    ->wrap()
                    ->lineClamp(2),
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
            ->groups([
                'game.game_title',
                'user.username',
            ])
            ->filters([
                Filter::make('star')
                    ->form([
                        Slider::make('star')
                            ->range(0, 5)
                            ->step(1)
                            ->tooltips(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['star'],
                            fn(Builder $query, $value) => $query->where('star', $value)
                        );
                    })
                    ->indicateUsing(function (array $data) {
                        if (!$data['star']) {
                            return null;
                        }

                        return "Star {$data['star']}";
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
