<?php

namespace App\Filament\Cooperative\Resources;

use App\Filament\Cooperative\Resources\OrderResource\Pages;
use App\Filament\Cooperative\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cooperative_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_address_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_cost')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('purchase_cost')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('delivery_cost')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('Pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cooperative_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_address_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_cost')
                    ->searchable(),
                Tables\Columns\TextColumn::make('delivery_cost')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
            // ->where('cooperative_id', auth()->user()->cooperative->id);
            
    }
}
