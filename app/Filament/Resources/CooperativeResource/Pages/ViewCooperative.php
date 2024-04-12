<?php

namespace App\Filament\Resources\CooperativeResource\Pages;

use App\Filament\Resources\CooperativeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCooperative extends ViewRecord
{
    protected static string $resource = CooperativeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
