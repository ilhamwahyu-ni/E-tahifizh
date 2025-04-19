<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MateriTahsin extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kelas',
        'semester',
        'topik_materi',
        'urutan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'kelas' => 'integer',
        'semester' => 'integer',
        'urutan' => 'integer',
    ];

    public function penilaianTahsins(): HasMany
    {
        return $this->hasMany(PenilaianTahsin::class);
    }
}
