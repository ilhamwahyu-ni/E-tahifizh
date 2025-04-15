<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    protected $fillable = [
        'name',
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

    protected static function booted(): void
    {
        static::created(function ($tahunAjaran) {
            // Create both semesters with is_active = false by default
            $tahunAjaran->semesters()->createMany([
                ['name' => 'Ganjil', 'type' => 1, 'is_active' => false],
                ['name' => 'Genap', 'type' => 2, 'is_active' => false],
            ]);
        });
    }
}
