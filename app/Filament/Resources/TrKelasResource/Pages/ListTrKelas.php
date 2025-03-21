<?php

namespace App\Filament\Resources\TrKelasResource\Pages;

use App\Filament\Resources\TrKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrKelas extends ListRecords
{
    protected static string $resource = TrKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
