<?php 


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'referred_id',
        'reward_claimed',
    ];

    // Relationship to referrer (user who referred someone)
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Relationship to referred user (user who was referred)
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }
}
