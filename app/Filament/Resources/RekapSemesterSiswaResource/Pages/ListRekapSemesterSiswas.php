<?php

namespace App\Filament\Resources\RekapSemesterSiswaResource\Pages;

use App\Filament\Resources\RekapSemesterSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapSemesterSiswas extends ListRecords
{
    protected static string $resource = RekapSemesterSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
