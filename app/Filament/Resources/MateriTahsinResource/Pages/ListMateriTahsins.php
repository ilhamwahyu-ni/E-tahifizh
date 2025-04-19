<?php

namespace App\Filament\Resources\MateriTahsinResource\Pages;

use App\Filament\Resources\MateriTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMateriTahsins extends ListRecords
{
    protected static string $resource = MateriTahsinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
