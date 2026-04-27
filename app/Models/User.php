<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'User_ID';
    protected $table = 'users';
    public $timestamps = false;
    
    protected $fillable = ['Role_ID', 'Name', 'Email', 'Password', 'Status', 'Created_at'];
    protected $hidden = ['Password'];
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'Role_ID', 'Role_ID');
    }

    public function policyAcknowledgments()
    {
        return $this->hasMany(PolicyAcknowledgment::class, 'User_ID', 'User_ID');
    }
}