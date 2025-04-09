<?php

namespace App\Filament\Resources\RombelResource\Pages;

use App\Filament\Resources\RombelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRombel extends CreateRecord
{
    protected static string $resource = RombelResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
