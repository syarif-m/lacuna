<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionCaseData extends Model
{
    protected $table = 'contribution_case_data';

    protected $primaryKey = 'contribution_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'contribution_id',
        'proposed_title',
        'proposed_summary',
        'central_mystery',
        'overview_content',
        'suggested_verification_status_tag_id',
        'suggested_explanation_status_tag_id',
    ];

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}