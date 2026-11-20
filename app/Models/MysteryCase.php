<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MysteryCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'created_by',
        'verification_status_tag_id',
        'explanation_status_tag_id',
        'title',
        'slug',
        'short_description',
        'central_mystery',
        'overview_content',
        'publication_status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verificationStatus(): BelongsTo
    {
        return $this->belongsTo(
            Tag::class,
            'verification_status_tag_id'
        );
    }

    public function explanationStatus(): BelongsTo
    {
        return $this->belongsTo(
            Tag::class,
            'explanation_status_tag_id'
        );
    }

        public function tags()
    {
        return $this->belongsToMany(Tag::class, 'case_tags', 'case_id', 'tag_id');
    }

    public function sources()
    {
        return $this->belongsToMany(Source::class, 'case_sources', 'case_id', 'source_id')
            ->withPivot('relevance_note');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CaseImage::class, 'case_id');
    }


    public function theories(): HasMany
    {
        return $this->hasMany(Theory::class, 'case_id');
    }

    public function explanations(): HasMany
    {
        return $this->hasMany(Explanation::class, 'case_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CaseComment::class, 'case_id');
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class, 'target_case_id');
    }
}