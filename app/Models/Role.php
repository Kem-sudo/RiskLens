<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'Role_ID';
    protected $table = 'roles';
    protected $fillable = ['Role_Name', 'Description'];
    
    public function users()
    {
        return $this->hasMany(User::class, 'Role_ID', 'Role_ID');
    }
}