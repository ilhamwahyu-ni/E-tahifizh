<?php

namespace App\Observers;

use App\Models\Semester;
use Illuminate\Support\Facades\Log;

class SemesterObserver
{
    public function creating(Semester $semester): void
    {
        if ($semester->is_active && $semester->tahun_ajaran_id) {
            Log::info("SemesterObserver (creating): New semester is active. Deactivating others in TahunAjaran ID {$semester->tahun_ajaran_id}.");
            $this->deactivateOthers($semester);
        }
    }

    public function updating(Semester $semester): void
    {
        if ($semester->isDirty('is_active') && $semester->is_active && $semester->tahun_ajaran_id) {
            Log::info("SemesterObserver (updating): Semester ID {$semester->id} changed to active. Deactivating others in TahunAjaran ID {$semester->tahun_ajaran_id}.");
            $this->deactivateOthers($semester);
        }
    }

    protected function deactivateOthers(Semester $activeSemester): void
    {
        Semester::withoutEvents(function () use ($activeSemester) {
            Semester::where('tahun_ajaran_id', $activeSemester->tahun_ajaran_id)
                ->where('id', '!=', $activeSemester->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });
    }
}
