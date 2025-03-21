<?php

namespace App\Filament\Resources\TmKelasResource\Pages;

use App\Filament\Resources\TmKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTmKelas extends ListRecords
{
    protected static string $resource = TmKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
