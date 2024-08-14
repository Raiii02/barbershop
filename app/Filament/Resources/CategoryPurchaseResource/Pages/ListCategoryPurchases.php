<?php

namespace App\Filament\Resources\CategoryPurchaseResource\Pages;

use App\Filament\Resources\CategoryPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryPurchases extends ListRecords
{
    protected static string $resource = CategoryPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
