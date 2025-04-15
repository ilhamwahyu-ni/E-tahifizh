<?php

namespace App\Observers;

use App\Models\TahunAjaran;
use App\Models\Semester;

class TahunAjaranObserver
{
    public function updating(TahunAjaran $tahunAjaran): void
    {
        // Only handle activation changes
        if (!$tahunAjaran->isDirty('is_active') || !$tahunAjaran->is_active) {
            return;
        }

        // Deactivate all other TahunAjaran
        TahunAjaran::withoutEvents(function () use ($tahunAjaran) {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });

        // Deactivate all Semester from other TahunAjaran
        Semester::withoutEvents(function () use ($tahunAjaran) {
            Semester::where('tahun_ajaran_id', '!=', $tahunAjaran->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        });

        // Set default semester activation for the new active TahunAjaran
        Semester::withoutEvents(function () use ($tahunAjaran) {
            // First, deactivate all semesters in this TahunAjaran
            Semester::where('tahun_ajaran_id', $tahunAjaran->id)
                ->update(['is_active' => false]);

            // Then activate only the first semester (Ganjil, type = 1)
            Semester::where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('type', 1)
                ->update(['is_active' => true]);
        });
    }
}
