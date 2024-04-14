<?php

namespace App\Filament\Cooperative\Resources\MinerResource\Pages;

use App\Filament\Cooperative\Resources\MinerResource;
use App\Models\Miner;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateMiner extends CreateRecord
{
    protected static string $resource = MinerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Miner created successfully')
            ->body('The miner has been created successfully');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['pin'] =  Hash::make(rand(100000, 999999));
        $lastMinerId = Miner::orderBy('id', 'desc')->first();
        $lastMinerId = $lastMinerId->id ?? 0;
        $data['account_number'] = 'MA' . str_pad($lastMinerId + 1, 8, '0', STR_PAD_LEFT);
        $data['cooperative_id'] = auth()->user()->cooperative->id;
        return $data;
    }
}
