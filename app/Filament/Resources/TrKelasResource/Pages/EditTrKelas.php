<?php

namespace App\Filament\Resources\TrKelasResource\Pages;

use App\Filament\Resources\TrKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrKelas extends EditRecord
{
    protected static string $resource = TrKelasResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
