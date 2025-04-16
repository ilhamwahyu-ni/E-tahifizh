<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Rombel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun_ajaran_id',
        'tm_kelas_id',
        'sekolah_id',
        'nama_rombongan',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tahun_ajaran_id' => 'integer',
        'tm_kelas_id' => 'integer',
        'sekolah_id' => 'integer',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function tmKelas(): BelongsTo
    {
        return $this->belongsTo(TmKelas::class);
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }



    public function hafalanSiswa(): HasManyThrough
    {
        return $this->hasManyThrough(HafalanSiswa::class, Siswa::class);
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }
}
