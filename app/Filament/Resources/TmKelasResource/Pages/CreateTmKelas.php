<?php

namespace App\Filament\Resources\TmKelasResource\Pages;

use App\Filament\Resources\TmKelasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTmKelas extends CreateRecord
{
    protected static string $resource = TmKelasResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
