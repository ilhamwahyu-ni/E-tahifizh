<?php

namespace App\Observers;

use App\Models\TahunAjaran;

class TahunAjaranObserver
{
    public function saving(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->is_active) {
            TahunAjaran::where('id', '!=', $tahunAjaran->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }
    }
}
