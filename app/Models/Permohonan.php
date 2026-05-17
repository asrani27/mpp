<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan';
    protected $fillable = [
        'nomor',
        'tanggal',
        'layanan_id',
        'petugas_id',
        'user_id',
        'nik',
        'nama',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusTrackings()
    {
        return $this->hasMany(StatusPermohonan::class);
    }

    // Status badge helpers
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'ditolak' => 'bg-red-100 text-red-800',
            'selesai' => 'bg-green-100 text-green-800',
        ];
        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'ditolak' => 'Ditolak',
            'selesai' => 'Selesai',
        ];
        return $labels[$this->status] ?? $this->status;
    }
}