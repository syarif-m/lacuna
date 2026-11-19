<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CaseComment extends Model
{
    use SoftDeletes;

    const UPDATED_AT = null;

    protected $fillable = [
        'case_id',
        'user_id',
        'body',
        'deleted_by_user_id',
    ];

    public function case(): BelongsTo
    {
        return $this->belongsTo(MysteryCase::class, 'case_id');
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