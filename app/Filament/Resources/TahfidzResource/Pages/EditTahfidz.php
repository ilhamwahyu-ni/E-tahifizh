<?php

namespace App\Filament\Resources\TahfidzResource\Pages;

use App\Filament\Resources\TahfidzResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahfidz extends EditRecord
{
    protected static string $resource = TahfidzResource::class;

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
