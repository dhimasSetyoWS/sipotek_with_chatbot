<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class MedicineKnowledge extends Model
{
    //
    protected $fillable = [
        'medicine_id',
        'indications',
        'contraindications',
        'warnings',
        'side_effects',
        'source_name',
        'source_url',
        'status',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
