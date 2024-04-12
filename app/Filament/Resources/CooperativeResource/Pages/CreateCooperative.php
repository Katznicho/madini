<?php

namespace App\Filament\Resources\CooperativeResource\Pages;

use App\Filament\Resources\CooperativeResource;
use App\Mail\AccountCreation;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;


class CreateCooperative extends CreateRecord
{
    protected static string $resource = CooperativeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Cooperative registered')
            ->body('The cooperative has been created successfully.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        try {
            //code...
            $email =  $data['email'];
            $name = $data['name'];
            // $data['account_number'] = 'MA'.str_pad(ran)
            $lastUserId = User::orderBy('id', 'desc')->first();
            $lastUserId = $lastUserId->id ?? 0;
            $data['account_number'] = 'MA' . str_pad($lastUserId + 1, 8, '0', STR_PAD_LEFT);
            User::create([
                'email' => $email,
                'password' => Hash::make($email),
                'name' => $data['name'],
                'type' => 'cooperative',
            ]);
            Mail::to($email)->send(new AccountCreation($name, $email));
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }


        return $data;
    }
}
