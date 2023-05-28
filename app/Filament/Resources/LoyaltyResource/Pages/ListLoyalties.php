<?php

namespace App\Filament\Resources\LoyaltyResource\Pages;

use App\Filament\Resources\LoyaltyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoyalties extends ListRecords
{
    protected static string $resource = LoyaltyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
