<?php

namespace App\Filament\Resources\ServiceTransactionResource\Pages;

use App\Filament\Resources\ServiceTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceTransactions extends ListRecords
{
    protected static string $resource = ServiceTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
