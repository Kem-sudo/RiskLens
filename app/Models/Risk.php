<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $primaryKey = 'RiskID';
    protected $table = 'risks';
    
    protected $fillable = ['RiskID', 'Category_ID', 'Reported_by', 'Risk_Title', 'Risk_Level', 'Description', 'Created_at'];
    
    public $timestamps = false;
    
    public function category()
    {
        return $this->belongsTo(RiskCategory::class, 'Category_ID', 'Category_ID');
    }
    
    public function reporter()
    {
        return $this->belongsTo(User::class, 'Reported_by', 'User_ID');
    }
}