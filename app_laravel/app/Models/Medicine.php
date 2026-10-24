<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Medicine extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'active_ingredients',
        'strength',
        'dosage_form',
        'registration_number',
        'classification',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(MedicineBatch::class);
    }
    public function knowledge(): HasOne
    {
        return $this->hasOne(MedicineKnowledge::class);
    }
}
