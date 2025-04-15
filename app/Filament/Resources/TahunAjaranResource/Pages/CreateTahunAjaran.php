<?php

namespace App\Filament\Resources\TahunAjaranResource\Pages;

use App\Filament\Resources\TahunAjaranResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Exception;
use Filament\Notifications\Notification;

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
        try {
            Log::info('Creating semesters for tahun ajaran ID: ' . $this->record->id);

            $semesters = $this->record->semesters()->createMany([
                [

                    'type' => 1,
                    'is_active' => false,
                ],
                [

                    'type' => 2,
                    'is_active' => false,
                ],
            ]);

            Log::info('Successfully created semesters', ['semesters' => $semesters]);

        } catch (Exception $e) {
            Log::error('Error creating semesters: ' . $e->getMessage(), [
                'tahun_ajaran_id' => $this->record->id,
                'trace' => $e->getTraceAsString()
            ]);

            Notification::make()
                ->title('Error Creating Semesters')
                ->body('Failed to create semesters. Please check the logs.')
                ->danger()
                ->send();
        }
    }
}
