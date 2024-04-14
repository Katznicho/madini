<?php

namespace App\Filament\Resources\MinerResource\Pages;

use App\Filament\Resources\MinerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMiner extends ViewRecord
{
    protected static string $resource = MinerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
