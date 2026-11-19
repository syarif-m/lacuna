<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionReview extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'contribution_id',
        'reviewer_id',
        'decision',
        'editorial_action',
        'resulting_explanation_id',
        'review_note',
        'verification_checklist_json',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'verification_checklist_json' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function resultingExplanation(): BelongsTo
    {
        return $this->belongsTo(
            Explanation::class,
            'resulting_explanation_id'
        );
    }
}