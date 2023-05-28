<?php

namespace App\Filament\Resources\StoreWorkerResource\Pages;

use App\Filament\Resources\StoreWorkerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStoreWorker extends EditRecord
{
    protected static string $resource = StoreWorkerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
