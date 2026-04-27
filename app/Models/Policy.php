<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $primaryKey = 'Policy_ID';
    protected $table = 'policies';
    
    protected $fillable = ['Policy_ID', 'Created_by', 'Policy_Title', 'Description', 'Created_at'];
    
    public $timestamps = false;
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'Created_by', 'User_ID');
    }

    public function acknowledgments()
    {
        return $this->hasMany(PolicyAcknowledgment::class, 'Policy_ID', 'Policy_ID');
    }
}