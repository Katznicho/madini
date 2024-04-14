<?php

namespace App\Filament\Resources\MinerResource\Pages;

use App\Filament\Resources\MinerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMiner extends EditRecord
{
    protected static string $resource = MinerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
