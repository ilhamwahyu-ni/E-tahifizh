<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tr_kelas_id',
        'nisn',
        'name',
        'gender',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tr_kelas_id' => 'integer',
    ];

    public function trKelas(): BelongsTo
    {
        return $this->belongsTo(TrKelas::class);
    }

    public function hafalanSiswas(): HasMany
    {
        return $this->hasMany(HafalanSiswa::class);
    }

    public function riwayatHafalans(): HasMany
    {
        return $this->hasMany(RiwayatHafalan::class);
    }

    public function tahfidz(): HasOne
    {
        return $this->hasOne(Tahfidz::class);
    }
}
