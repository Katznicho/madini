<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MinerResource\Pages;
use App\Filament\Resources\MinerResource\RelationManagers;
use App\Models\Miner;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class MinerResource extends Resource
{
    protected static ?string $model = Miner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Miners';

    public static function getGloballySearchableAttributes(): array
    {
        return ["name", "description"];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(
                    fn ($context) =>
                    $context === 'edit' ? 'Editing miner' : ($context === 'create' ? 'Creating a new miner' : 'Viewing miner')
                )
                    ->description(fn ($context) => $context === 'edit' ? 'Editing an existing miner record.' : ($context === 'create' ? 'Creating a new miner record.' : 'Viewing a miner record.'))
                
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('active'),
                    //gender
                Forms\Components\Select::make('gender')
                ->required()
                ->options(
                    [
                        'male' => 'Male',
                        'female' => 'Female',
                    ]
                    ),
                Forms\Components\TextInput::make('miner_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pin_recovery')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pin_reset')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('profile_picture')
                    ->directory('miner')
                    ->image()
                    ->label('miner profile picture')
                    ->required(),


                ])
            
              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                ->label("Cover Image")
                ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label("Miner Name"),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('miner_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pin_recovery')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pin_reset')
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
                Filter::make('is_sponsored')
                ->query(fn (Builder $query): Builder => $query->where('is_sponsored', true))
                ->indicator(fn (Builder $query): int => $query->where('is_sponsored', true)->count())
                ->toggle()
                ->label('Sponsored'),
            Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['from'] ?? null) {
                        $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                            ->removeField('from');
                    }

                    if ($data['until'] ?? null) {
                        $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                            ->removeField('until');
                    }

                    return $indicators;
                }),
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
            'index' => Pages\ListMiners::route('/'),
            'create' => Pages\CreateMiner::route('/create'),
            'view' => Pages\ViewMiner::route('/{record}'),
            'edit' => Pages\EditMiner::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
