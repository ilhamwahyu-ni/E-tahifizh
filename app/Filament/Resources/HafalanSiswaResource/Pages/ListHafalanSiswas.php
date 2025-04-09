<?php

namespace App\Filament\Resources\HafalanSiswaResource\Pages;

use App\Filament\Resources\HafalanSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHafalanSiswas extends ListRecords
{
    protected static string $resource = HafalanSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
