<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceTransactionResource\Pages;
use App\Filament\Resources\ServiceTransactionResource\RelationManagers;
use App\Models\CategoryService;
use App\Models\ServiceTransaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceTransactionResource extends Resource
{
    protected static ?string $model = ServiceTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Services';

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
                        Select::make('service_id')
                            ->label('Service Name')
                            ->options(CategoryService::all()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) use ($form) {
                                $categoryService = CategoryService::find($state);
                                if ($categoryService) {
                                    $price = $categoryService->price;
                                    $set('price', $price);

                                    $quantity = $form->getState()['quantity'] ?? 1;
                                    $amount = $price * $quantity;

                                    $set('amount', $amount);
                                } else {
                                    $set('price', null);
                                    $set('amount', null);
                                }
                            }),
                        TextInput::make('price')
                            ->label('Price')
                            ->readOnly(true)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->prefix('Rp '),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) use ($form) {
                                $price = $form->getState()['price'] ?? 0;
                                $amount = $price * $state;
                                $set('amount', $amount);
                            }),
                        TextInput::make('amount')
                            ->label('Amount')
                            ->readOnly(true)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->prefix('Rp '),
                        DatePicker::make('service_transaction_date')
                            ->label('Transaction Date')
                            ->native(false)
                            ->displayFormat('l, d F Y')
                            ->default(now())
                            ->required(),
                        RichEditor::make('notes')
                            ->label('Notes')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ]),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('CategoryService.name')
                    ->label('Service Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('CategoryService.price')
                    ->label('Price')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        if ($state !== NULL) {
                            return 'Rp ' . number_format($state, 0, ',', '.');
                        } else {
                            return '-';
                        }
                    }),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        if ($record->amount !== NULL) {
                            return 'Rp ' . number_format($record->amount, 0, ',', '.');
                        } else {
                            return false;
                        }
                    }),
                TextColumn::make('service_transaction_date')
                    ->label('Date')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('notes')
                    ->label('Service Note')
                    ->sortable()
                    ->searchable()
                    ->html()
                    ->formatStateUsing(function ($state) {
                        if ($state !== NULL) {
                            return $state;
                        } else {
                            return '-';
                        }
                    }),
                IconColumn::make('is_income')
                    ->label('Is Income')
                    ->trueIcon('heroicon-o-arrow-down-circle')
                    ->trueColor('success')
                    ->boolean(),
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
            'index' => Pages\ListServiceTransactions::route('/'),
            'create' => Pages\CreateServiceTransaction::route('/create'),
            'edit' => Pages\EditServiceTransaction::route('/{record}/edit'),
        ];
    }
}
