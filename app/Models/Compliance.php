<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    protected $primaryKey = 'Compliance_ID';
    protected $table = 'compliance';
    
    protected $fillable = [
        'Compliance_ID', 
        'PolicyID', 
        'Checked_by', 
        'Status', 
        'Review_Date', 
        'Remarks'
    ];
    
    public $timestamps = true;
    
    public function policy()
    {
        return $this->belongsTo(Policy::class, 'PolicyID', 'Policy_ID');
    }
    
    public function checker()
    {
        return $this->belongsTo(User::class, 'Checked_by', 'User_ID');
    }
}