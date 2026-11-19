<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theory extends Model
{
    protected $fillable = [
        'case_id',
        'created_by',
        'title',
        'slug',
        'summary',
        'body',
        'publication_status',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(
            MysteryCase::class,
            'case_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(
            Source::class,
            'theory_sources'
        )->withPivot('relevance_note');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TheoryComment::class, 'theory_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(TheoryVote::class, 'theory_id');
    }
}