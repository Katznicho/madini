<?php

namespace App\Filament\Cooperative\Resources\ProductResource\Pages;

use App\Filament\Cooperative\Resources\ProductResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created successfully')
            ->body('The product has been created successfully');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['cooperative_id'] = auth()->user()->cooperative->id;
        return $data;
    }
}
