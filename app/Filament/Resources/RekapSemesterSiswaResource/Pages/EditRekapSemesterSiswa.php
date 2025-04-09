<?php

namespace App\Filament\Resources\RekapSemesterSiswaResource\Pages;

use App\Filament\Resources\RekapSemesterSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekapSemesterSiswa extends EditRecord
{
    protected static string $resource = RekapSemesterSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
