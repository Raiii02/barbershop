<?php

namespace App\Filament\Resources\CategoryPurchaseResource\Pages;

use App\Filament\Resources\CategoryPurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryPurchase extends EditRecord
{
    protected static string $resource = CategoryPurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
