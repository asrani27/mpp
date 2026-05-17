<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'instansi_id',
        'nama',
        'deskripsi',
        'syarat',
        'lama_proses',
        'status',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}