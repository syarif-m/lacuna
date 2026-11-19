<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TheoryVote extends Model
{
    protected $fillable = [
        'theory_id',
        'user_id',
        'choice',
    ];

    public function theory(): BelongsTo
    {
        return $this->belongsTo(Theory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}