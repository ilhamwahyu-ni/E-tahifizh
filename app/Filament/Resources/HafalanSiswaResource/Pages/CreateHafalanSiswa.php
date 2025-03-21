<?php

namespace App\Filament\Resources\HafalanSiswaResource\Pages;

use App\Filament\Resources\HafalanSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHafalanSiswa extends CreateRecord
{
    protected static string $resource = HafalanSiswaResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
