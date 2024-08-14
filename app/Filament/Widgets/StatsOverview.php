<?php

namespace App\Filament\Widgets;

use App\Models\PurchaseTransaction;
use App\Models\ServiceTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $incomes = ServiceTransaction::where('is_income', true)->sum('amount');
        $expenses = PurchaseTransaction::where('is_expense', true)->sum('amount');
        $customers = ServiceTransaction::whereDate('service_transaction_date', today())->sum('quantity');

        return [
            Stat::make('Number of Customers', $customers),
            Stat::make('Incomes', $incomes),
            Stat::make('Expenses', $expenses),
            Stat::make('Profit', $incomes - $expenses),
        ];
    }
}
