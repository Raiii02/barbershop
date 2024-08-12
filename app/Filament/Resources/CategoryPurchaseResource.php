<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryPurchaseResource\Pages;
use App\Models\CategoryPurchase;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoryPurchaseResource extends Resource
{
    protected static ?string $model = CategoryPurchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Purchases';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'sm' => 3,
                    'xl' => 1,
                    '2xl' => 1,
                ])
                    ->schema([
                        TextInput::make('name')->required()->label('Purchase Name'),
                        TextInput::make('price')
                            ->required()
                            ->label('Purchase Price')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->prefix('Rp ')
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Purchase Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Purchase Price')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        if ($record->price !== NULL) {
                            return 'Rp ' . number_format($record->price, 0, ',', '.');
                        } else {
                            return false;
                        }
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryPurchases::route('/'),
            'create' => Pages\CreateCategoryPurchase::route('/create'),
            'edit' => Pages\EditCategoryPurchase::route('/{record}/edit'),
        ];
    }
}
