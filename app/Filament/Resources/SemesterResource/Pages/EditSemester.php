<?php

namespace App\Filament\Resources\SemesterResource\Pages;

use App\Filament\Resources\SemesterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSemester extends EditRecord
{
    protected static string $resource = SemesterResource::class;

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
