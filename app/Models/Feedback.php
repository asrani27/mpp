<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'tanggal',
        'user_id',
        'layanan_id',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    /**
     * Get the user that owns the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the layanan that owns the feedback.
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * Get rating label based on rating value.
     */
    public function getRatingLabelAttribute(): string
    {
        $labels = [
            1 => 'Sangat Buruk',
            2 => 'Buruk',
            3 => 'Cukup',
            4 => 'Baik',
            5 => 'Sangat Baik',
        ];
        return $labels[$this->rating] ?? 'Unknown';
    }
}