<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CooperativeResource\Pages;
use App\Filament\Resources\CooperativeResource\RelationManagers;
use App\Models\Cooperative;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use AbanoubNassem\FilamentPhoneField\Forms\Components\PhoneInput;

class CooperativeResource extends Resource
{
    protected static ?string $model = Cooperative::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cooperatives';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(
                    fn ($context) =>
                    $context === 'edit' ? 'Editing cooperative' : ($context === 'create' ? 'Creating a new cooperative' : 'Viewing cooperative')
                )
                    ->description(fn ($context) => $context === 'edit' ? 'Editing an existing cooperative record.' : ($context === 'create' ? 'Creating a new cooperative record.' : 'Viewing a cooperative record.'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->tel()
                            ->maxLength(255)
                            ->unique('cooperatives', 'phone_number')
                            ->required()
                            ->default(null),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->default(null),
                        MarkdownEditor::make('description')
                            ->required()
                            ->label("Description"),
                        Forms\Components\FileUpload::make('logo')
                            ->directory('cooperative')
                            ->image()
                            ->label('Cooperative Image'),
                        // Forms\Components\TextInput::make('status')
                        //     ->required()
                        //     ->maxLength(255)
                        //     ->default('active'),

                        Forms\Components\TextInput::make('website')
                            ->maxLength(255)
                            ->label("Website URL")
                            ->url()
                            ->default(null),
                        // Forms\Components\TextInput::make('account_number')
                        //     ->maxLength(255)
                        //     ->default(null),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255)
                            ->default(null),

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
                    ->label("Cooperative Name"),
                Tables\Columns\TextColumn::make('account_number')
                    ->searchable()
                    ->toggleable()
                    ->label("Account Number")
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable()
                    ->toggleable()
                    ->label("Phone Number")
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
                    ->label("Email")
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label("Description"),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->label("Status")
                    ->badge(fn (Cooperative $record): string => $record->status === 'active' ? 'success' : 'danger')
                    ->color(fn (Cooperative $record): string => $record->status === 'active' ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
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
            'index' => Pages\ListCooperatives::route('/'),
            'create' => Pages\CreateCooperative::route('/create'),
            'view' => Pages\ViewCooperative::route('/{record}'),
            'edit' => Pages\EditCooperative::route('/{record}/edit'),
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
