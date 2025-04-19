<?php

namespace App\Filament\Resources\PenilaianTahsinResource\Pages;

use App\Filament\Resources\PenilaianTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenilaianTahsins extends ListRecords
{
    protected static string $resource = PenilaianTahsinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
