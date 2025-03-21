<?php

namespace App\Filament\Resources\TahfidzResource\Pages;

use App\Filament\Resources\TahfidzResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahfidzs extends ListRecords
{
    protected static string $resource = TahfidzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
