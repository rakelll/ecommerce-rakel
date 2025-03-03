<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class orderstats extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the average grand total and ensure it is never null
        $averageGrandTotal = Order::query()->avg('grand_total') ?? 0;

        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),
            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),
            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),
            Stat::make('Average Price', Number::currency($averageGrandTotal, 'USD')) // Pass the sanitized value
        ];
    }
}
