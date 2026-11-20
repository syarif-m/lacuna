<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tag_kind',
    ];

    public function classifiedCases()
    {
        return $this->belongsToMany(MysteryCase::class, 'case_tags', 'tag_id', 'case_id');
    }

    public function verificationCases(): HasMany
    {
        return $this->hasMany(
            MysteryCase::class,
            'verification_status_tag_id'
        );
    }

    public function explanationCases(): HasMany
    {
        return $this->hasMany(
            MysteryCase::class,
            'explanation_status_tag_id'
        );
    }
}