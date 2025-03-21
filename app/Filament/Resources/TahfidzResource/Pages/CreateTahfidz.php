<?php

namespace App\Filament\Resources\TahfidzResource\Pages;

use App\Filament\Resources\TahfidzResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahfidz extends CreateRecord
{
    protected static string $resource = TahfidzResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
