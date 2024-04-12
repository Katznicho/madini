<?php

namespace App\Filament\Resources\CooperativeResource\Pages;

use App\Filament\Resources\CooperativeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCooperative extends EditRecord
{
    protected static string $resource = CooperativeResource::class;

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
