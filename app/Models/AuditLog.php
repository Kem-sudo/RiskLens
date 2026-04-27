<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $primaryKey = 'Log_ID';
    protected $table = 'audit_logs';
    
    protected $fillable = ['Log_ID', 'User_ID', 'Action', 'Module', 'Timestamp'];
    
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}