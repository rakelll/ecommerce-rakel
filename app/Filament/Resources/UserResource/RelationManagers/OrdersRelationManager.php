<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Order Id')
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
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])

                ->actions([
                    Action::make('View Order')
                        ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                        ->color('info')
                        ->icon('heroicon-o-eye'),
                    DeleteAction::make(),
                ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
