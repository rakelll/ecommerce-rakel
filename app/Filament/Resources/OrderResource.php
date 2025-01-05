<?php

namespace App\Filament\Resources;



use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                Group::make()->schema([
                Section::make('Order Information')->schema([
                    Select::make('user_id')
                    ->label('customer')
                    ->relationship('user','name')
                    ->searchable()
                    ->preload()
                    ->required(),

                    Select::make('payment_method')
                    ->options([
                        'stripe'=>'Stripe',
                        'cod'=>'Cash On Delivery'
                    ])->required(),

                    Select::make('payment_status')
                    ->options([
                        'pending'=>'Pending',
                        'paid'=>'Paid',
                        'failed'=>'Failed'
                    ])->required()
                    ->default('pending'),

                    ToggleButtons::make('status')
                    ->inline()
                    ->default('new')
                    ->required()
                    ->options([
                        'new'=>'New',
                        'processing'=>'Processing',
                        'shipped'=>'Shipped',
                        'delivered'=>'Delivered',
                        'canceled'=>'Canceled'
                    ])
                    ->colors([
                        'new'=>'info',
                        'processing'=>'warning',
                        'shipped'=>'success',
                        'delivered'=>'success',
                        'canceled'=>'danger'
                    ])
                    ->icons([

                             'new'=>'heroicon-m-sparkles',
                        'processing'=>'heroicon-m-arrow-path',
                        'shipped'=>'heroicon-m-truck',
                        'delivered'=>'heroicon-m-check-badge',
                        'canceled'=>'heroicon-m-x-circle'          ]),
                    Select::make('currency')
                    ->options([
                        'usd'=>'USD',
                        'lbp'=>'LBP',
                        'eur'=>'EUR'
                    ])->required()
                    ->default('usd'),

                    Select::make('shipping_method')
                    ->options([
                        'fedex'=>'fedEx',
                        'ups'=>'UPS',
                        'usps'=>'USPS'
                    ]),
                    Textarea::make('notes')
                    ->columnSpanFull()

                ])->columns(2),

                    Section::make('Order items')->schema([

                        Repeater::make('items')

                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                            ->relationship('product','name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->distinct()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan(3)
                            ->reactive()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $unitAmount = Product::find($state)?->price ?? 0;
                                $set('unit_amount', $unitAmount);
                                $tva = $unitAmount * 0.11; // Calculate 11% tax
                                $set('tva', $tva); // Set the TVA
                                $set('total_amount', $unitAmount + $tva); // Include TVA in total amount
                            }),


                            TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(1)
                            ->columnSpan(2)
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                $unitAmount = $get('unit_amount');
                                $tva = $get('tva');
                                $set('total_amount', ($unitAmount + $tva) * $state);
                            }),


                            TextInput::make('unit_amount')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(2),

                            Placeholder::make('tva')
                            ->label('TVA (11%)')
                            ->columnSpan(2)
                            ->content(function (Get $get) {
                                return Number::currency($get('tva') ?? 0, 'USD');
                            }),

                            TextInput::make('total_amount')
                            ->numeric()
                            ->required()
                            ->dehydrated()
                            ->columnSpan(3),

                        ])->columns(12),

                        Placeholder::make('grand_total_placeholder')
                        ->label('Grand Total')
                        ->content(function (Get $get ,Set $set){
                            $total=0;
                            if(!$repeaters =$get('items')){
                                return $total;
                            }
                            foreach($repeaters as $key=>$repeater){
                                $total += $get("items.{$key}.total_amount");
                            }
                            $set('grand_total',$total);
                            return Number::currency($total,'USD');
                        }),
                        Hidden::make('grand_total')
                        ->default(0)
                    ])



            ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('grand_total')
                    ->numeric()
                    ->money('USD')
                    ->sortable(),
                    Tables\Columns\TextColumn::make('tax_amount')
                ->numeric()
                ->money('USD') // Adjust as needed
                ->label('Tax Amount')
                ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_method')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'new'=>'New',
                        'processing'=>'Processing',
                        'shipped'=>'Shipped',
                        'delivered'=>'Delivered',
                        'canceled'=>'Canceled'
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }
        public static function getNavigationBadge(): ?string
        {
  return cache()->remember('orders_count', 60, function () {
            return static::getModel()::count();
        });
}
       public static function getNavigationBadgeColor(): string|array|null
       {
 return static::getModel()::count() > 10 ? 'success' : 'danger';
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
