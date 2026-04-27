<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolicyAcknowledgment extends Model
{
    protected $primaryKey = 'Acknowledgment_ID';
    protected $table = 'policy_acknowledgments';
    public $timestamps = false;

    protected $fillable = ['Policy_ID', 'User_ID', 'Acknowledged_at'];

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'Policy_ID', 'Policy_ID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}
