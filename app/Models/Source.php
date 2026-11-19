<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Source extends Model
{
    protected $fillable = [
        'source_type',
        'traceability_level',
        'title',
        'author',
        'publisher_or_platform',
        'published_at',
        'url',
        'description',
        'accessed_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'accessed_at' => 'datetime',
        ];
    }

   public function cases()
    {
    return $this->belongsToMany(MysteryCase::class, 'case_sources', 'source_id', 'case_id')
        ->withPivot('relevance_note');
    }

    public function theories(): BelongsToMany
    {
        return $this->belongsToMany(
            Theory::class,
            'theory_sources'
        )->withPivot('relevance_note');
    }

    public function explanations(): BelongsToMany
    {
        return $this->belongsToMany(
            Explanation::class,
            'explanation_sources'
        )->withPivot('relevance_note');
    }
}