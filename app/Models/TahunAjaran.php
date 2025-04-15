<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Exception;
use Illuminate\Support\Facades\Log as FacadesLog;
use Log;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahun',
        'nama',
        'is_active',
        // ... other fillable attributes
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class);
    }


}
