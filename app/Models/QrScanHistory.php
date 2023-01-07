<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrScanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_id',
        'scanned_by',
    ];

    public function scanned_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
