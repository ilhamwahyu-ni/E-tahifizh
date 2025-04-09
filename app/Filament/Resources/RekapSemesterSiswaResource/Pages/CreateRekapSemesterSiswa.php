<?php

namespace App\Filament\Resources\RekapSemesterSiswaResource\Pages;

use App\Filament\Resources\RekapSemesterSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRekapSemesterSiswa extends CreateRecord
{
    protected static string $resource = RekapSemesterSiswaResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
