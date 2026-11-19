<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionImage extends Model
{
    protected $fillable = [
        'contribution_id',
        'source_id',
        'temporary_image_path',
        'alt_text',
        'caption',
        'context_description',
        'sort_order',
    ];

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}