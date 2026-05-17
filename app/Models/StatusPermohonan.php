<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPermohonan extends Model
{
    use HasFactory;

    protected $table = 'status_permohonan';

    protected $fillable = [
        'permohonan_id',
        'status',
        'keterangan',
        'petugas_id',
    ];

    // Relationships
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}