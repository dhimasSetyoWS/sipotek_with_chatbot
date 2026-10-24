<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineBatch extends Model
{
    protected $fillable = [
        'medicine_id',
        'batch_number',
        'stock_quantity',
        'expiry_date',
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'expiry_date' => 'date',
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
