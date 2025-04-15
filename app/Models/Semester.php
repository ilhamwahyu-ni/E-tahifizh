<?php

namespace App\Models;

use App\Observers\SemesterObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Semester extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_GANJIL = 1;
    public const TYPE_GENAP = 2;

    protected $fillable = [
        'type',
        'tahun_ajaran_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn() => ($this->type ?? self::TYPE_GANJIL) === self::TYPE_GANJIL ? 'Ganjil' : 'Genap',
        );
    }

    public function scopeGanjil($query)
    {
        return $query->where('type', self::TYPE_GANJIL);
    }

    public function scopeGenap($query)
    {
        return $query->where('type', self::TYPE_GENAP);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
