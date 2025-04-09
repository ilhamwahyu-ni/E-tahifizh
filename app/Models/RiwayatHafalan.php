<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatHafalan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hafalan_siswa_id',
        'catatan',
        'status',
        'tanggal',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'hafalan_siswa_id' => 'integer',
        'tanggal' => 'timestamp',
    ];

    public function hafalanSiswa(): BelongsTo
    {
        return $this->belongsTo(HafalanSiswa::class);
    }
}
