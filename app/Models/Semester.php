<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute; // Untuk Laravel 9+

class Semester extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_GANJIL = 1;
    public const TYPE_GENAP = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type', // sebelumnya 'nama'
        'is_active', // sebelumnya 'status'
        'tahun_ajaran_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the semester's name (Ganjil/Genap).
     * Menggunakan accessor modern (Laravel 9+)
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->type ?? self::TYPE_GANJIL) === self::TYPE_GANJIL ? 'Ganjil' : 'Genap', // Tambah null check
        );
    }

    /* // Accessor untuk Laravel < 9
    public function getNamaAttribute()
    {
         $type = $this->attributes['type'] ?? self::TYPE_GANJIL; // Tambah null check
         return $type === self::TYPE_GANJIL ? 'Ganjil' : 'Genap';
    }
    */

    /**
     * Scope a query to only include ganjil semesters.
     */
    public function scopeGanjil($query)
    {
        return $query->where('type', self::TYPE_GANJIL);
    }

    /**
     * Scope a query to only include genap semesters.
     */
    public function scopeGenap($query)
    {
        return $query->where('type', self::TYPE_GENAP);
    }

    /**
     * Get the tahun ajaran that owns the semester.
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
