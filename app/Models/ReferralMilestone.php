<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'milestone',
        'reward',
    ];

    // Relationship to the referrer
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
}
