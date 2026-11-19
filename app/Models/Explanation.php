<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Explanation extends Model
{
    protected $fillable = [
        'case_id',
        'curated_by_admin_id',
        'title',
        'body',
        'publication_status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function case(): BelongsTo
    {
        return $this->belongsTo(
            MysteryCase::class,
            'case_id'
        );
    }

    public function curator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'curated_by_admin_id'
        );
    }

    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(
            Source::class,
            'explanation_sources'
        )->withPivot('relevance_note');
    }
}