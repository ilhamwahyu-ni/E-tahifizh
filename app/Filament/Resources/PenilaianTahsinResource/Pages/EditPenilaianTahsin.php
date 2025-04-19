<?php

namespace App\Filament\Resources\PenilaianTahsinResource\Pages;

use App\Filament\Resources\PenilaianTahsinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenilaianTahsin extends EditRecord
{
    protected static string $resource = PenilaianTahsinResource::class;

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
