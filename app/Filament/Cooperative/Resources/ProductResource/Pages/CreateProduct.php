<?php

namespace App\Filament\Cooperative\Resources\ProductResource\Pages;

use App\Filament\Cooperative\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
