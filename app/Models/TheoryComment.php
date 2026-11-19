<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TheoryComment extends Model
{
    use SoftDeletes;

    const UPDATED_AT = null;

    protected $fillable = [
        'theory_id',
        'user_id',
        'body',
        'deleted_by_user_id',
    ];

    public function theory(): BelongsTo
    {
        return $this->belongsTo(Theory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_user_id');
    }
}