<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseImage extends Model
{
    protected $fillable = [
        'case_id',
        'source_id',
        'image_path',
        'alt_text',
        'caption',
        'context_description',
        'sort_order',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(
            MysteryCase::class,
            'case_id'
        );
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}