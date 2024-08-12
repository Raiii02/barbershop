<?php

namespace App\Filament\Resources\ServiceTransactionResource\Pages;

use App\Filament\Resources\ServiceTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceTransaction extends EditRecord
{
    protected static string $resource = ServiceTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
