<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use App\Filament\Resources\DeliveryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDelivery extends CreateRecord
{
    protected static string $resource = DeliveryResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Delivery created successfully')
            ->body('The delivery has been created successfully');
    }
}
