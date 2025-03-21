<?php

namespace App\Filament\Resources\RiwayatHafalanResource\Pages;

use App\Filament\Resources\RiwayatHafalanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatHafalans extends ListRecords
{
    protected static string $resource = RiwayatHafalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
