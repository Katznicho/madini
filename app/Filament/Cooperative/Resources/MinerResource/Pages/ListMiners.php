<?php

namespace App\Filament\Cooperative\Resources\MinerResource\Pages;

use App\Filament\Cooperative\Resources\MinerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMiners extends ListRecords
{
    protected static string $resource = MinerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
