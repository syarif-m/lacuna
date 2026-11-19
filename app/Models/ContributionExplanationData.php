<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionExplanationData extends Model
{
    protected $table = 'contribution_explanation_data';

    protected $primaryKey = 'contribution_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'contribution_id',
        'proposed_title',
        'proposed_body',
    ];

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}