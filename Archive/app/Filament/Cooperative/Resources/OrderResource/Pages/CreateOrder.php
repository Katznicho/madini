<?php

namespace App\Filament\Cooperative\Resources\OrderResource\Pages;

use App\Filament\Cooperative\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
