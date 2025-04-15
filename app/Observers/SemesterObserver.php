<?php

namespace App\Observers;

use App\Models\Semester;

class SemesterObserver
{
    public function updating(Semester $semester): void
    {
        if (!$semester->isDirty('is_active') || !$semester->is_active) {
            return;
        }

        // Deactivate other semesters in the same TahunAjaran
        Semester::withoutEvents(function () use ($semester) {
            Semester::where('tahun_ajaran_id', $semester->tahun_ajaran_id)
                ->where('id', '!=', $semester->id)
                ->update(['is_active' => false]);
        });
    }
}
