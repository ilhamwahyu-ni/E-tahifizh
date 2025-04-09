<?php

namespace App\Filament\Resources\HafalanSiswaResource\Pages;

use App\Filament\Resources\HafalanSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHafalanSiswa extends EditRecord
{
    protected static string $resource = HafalanSiswaResource::class;

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
