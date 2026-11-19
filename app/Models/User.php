<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password_hash',
        'role',
        'account_status',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password_hash' => 'hashed',
        ];
    }

    /**
     * Tell Laravel which column stores the user's password.
     */
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function createdContributions()
    {
        return $this->hasMany(Contribution::class, 'submitted_by');
    }

    public function createdCases()
    {
        return $this->hasMany(MysteryCase::class, 'created_by');
    }

    public function createdTheories()
    {
        return $this->hasMany(Theory::class, 'created_by');
    }

    public function caseComments()
    {
        return $this->hasMany(CaseComment::class);
    }

    public function theoryComments()
    {
        return $this->hasMany(TheoryComment::class);
    }

    public function theoryVotes()
    {
        return $this->hasMany(TheoryVote::class);
    }

    public function contributionReviews()
    {
        return $this->hasMany(ContributionReview::class, 'reviewer_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'actor_user_id');
    }
}
