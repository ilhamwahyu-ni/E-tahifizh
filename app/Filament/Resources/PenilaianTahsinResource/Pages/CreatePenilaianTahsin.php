<?php

namespace App\Filament\Resources\PenilaianTahsinResource\Pages;

use App\Filament\Resources\PenilaianTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePenilaianTahsin extends CreateRecord
{
    protected static string $resource = PenilaianTahsinResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
