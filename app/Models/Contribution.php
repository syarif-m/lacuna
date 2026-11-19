<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contribution extends Model
{
    protected $fillable = [
        'submitted_by',
        'contribution_type',
        'target_case_id',
        'current_status',
        'submitted_at',
        'withdrawn_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'withdrawn_at' => 'datetime',
        ];
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function targetCase(): BelongsTo
    {
        return $this->belongsTo(MysteryCase::class, 'target_case_id');
    }

    public function caseData(): HasOne
    {
        return $this->hasOne(ContributionCaseData::class);
    }

    public function theoryData(): HasOne
    {
        return $this->hasOne(ContributionTheoryData::class);
    }

    public function explanationData(): HasOne
    {
        return $this->hasOne(ContributionExplanationData::class);
    }

    public function informationData(): HasOne
    {
        return $this->hasOne(ContributionInformationData::class);
    }

    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(
            Source::class,
            'contribution_sources'
        )->withPivot('section_type', 'relevance_note');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ContributionImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ContributionReview::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'contribution_tags'
        );
    }
}