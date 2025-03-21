<?php

namespace App\Filament\Resources\RiwayatHafalanResource\Pages;

use App\Filament\Resources\RiwayatHafalanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRiwayatHafalan extends CreateRecord
{
    protected static string $resource = RiwayatHafalanResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
