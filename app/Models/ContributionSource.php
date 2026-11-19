<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionSource extends Model
{
    protected $table = 'contribution_sources';

    public $timestamps = false;

    protected $fillable = [
        'contribution_id',
        'source_id',
        'section_type',
        'relevance_note',
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