<?php

namespace App\Filament\Resources\MateriTahsinResource\Pages;

use App\Filament\Resources\MateriTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMateriTahsin extends CreateRecord
{
    protected static string $resource = MateriTahsinResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
