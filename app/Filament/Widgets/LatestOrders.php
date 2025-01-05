<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string |array $columnSpan='full';
    protected static ?int $sort=2;

    public function table(Table $table): Table
    {
        return $table
            ->query( OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at','desc')

            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Order Id')
                ->searchable(),

                Tables\Columns\TextColumn::make('user.name')

                ->searchable(),


                Tables\Columns\TextColumn::make('grand_total')
                ->money('USD')
                ->searchable(),




                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn(string $state):string=>match($state){
                    'new'=>'info',
                    'processing'=>'warning',
                    'shipped'=>'success',
                    'delivered'=>'success',
                    'canceled'=>'danger'
                })
                ->icon(fn(string $state):string=>match($state){
                    'new'=>'heroicon-m-sparkles',
                    'processing'=>'heroicon-m-arrow-path',
                    'shipped'=>'heroicon-m-truck',
                    'delivered'=>'heroicon-m-check-badge',
                    'canceled'=>'heroicon-m-x-circle'
                    })
                ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('payment_status')
                ->sortable()
                ->searchable()
                ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
                ])
                ->actions([
                    Action::make('View Order')
                        ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                        ->color('info')
                        ->icon('heroicon-o-eye'),
                    DeleteAction::make(),

                ]);
    }
}
