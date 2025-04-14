<?php

namespace App\Filament\Resources\TahunAjaranResource\Pages;

use App\Filament\Resources\TahunAjaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunAjaran extends CreateRecord
{
    protected static string $resource = TahunAjaranResource::class;
    protected static bool $canCreateAnother = false;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $tahunAjaran = $this->record;

        // Create Semester Ganjil
        $tahunAjaran->semesters()->create([
            'nama' => 'Ganjil',
            'status' => 'nonaktif', // Default status
        ]);

        // Create Semester Genap
        $tahunAjaran->semesters()->create([
            'nama' => 'Genap',
            'status' => 'nonaktif', // Default status
        ]);
    }
}
