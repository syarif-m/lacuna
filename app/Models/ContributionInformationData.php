<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionInformationData extends Model
{
    protected $table = 'contribution_information_data';

    protected $primaryKey = 'contribution_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'contribution_id',
        'subject',
        'information_content',
        'context_note',
    ];

    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }
}