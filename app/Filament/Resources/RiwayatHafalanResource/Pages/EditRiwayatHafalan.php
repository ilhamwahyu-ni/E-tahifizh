<?php

namespace App\Filament\Resources\RiwayatHafalanResource\Pages;

use App\Filament\Resources\RiwayatHafalanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatHafalan extends EditRecord
{
    protected static string $resource = RiwayatHafalanResource::class;

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
