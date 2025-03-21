<?php

namespace App\Filament\Resources\TrKelasResource\Pages;

use App\Filament\Resources\TrKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrKelas extends CreateRecord
{
    protected static string $resource = TrKelasResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
