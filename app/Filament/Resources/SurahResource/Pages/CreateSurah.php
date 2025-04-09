<?php

namespace App\Filament\Resources\SurahResource\Pages;

use App\Filament\Resources\SurahResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSurah extends CreateRecord
{
    protected static string $resource = SurahResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
