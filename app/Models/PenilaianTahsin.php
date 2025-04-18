<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianTahsin extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'siswa_id',
        'materi_tahsin_id',
        'semester_id',
        'tahun_ajaran_id',
        'nilai_angka',
        'tanggal_penilaian',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'siswa_id' => 'integer',
        'materi_tahsin_id' => 'integer',
        'semester_id' => 'integer',
        'tahun_ajaran_id' => 'integer',
        'nilai_angka' => 'integer',
        'tanggal_penilaian' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function materiTahsin(): BelongsTo
    {
        return $this->belongsTo(MateriTahsin::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
