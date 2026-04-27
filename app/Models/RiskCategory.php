<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskCategory extends Model
{
    protected $primaryKey = 'Category_ID';
    protected $table = 'risk_categories';
    
    protected $fillable = ['Category_ID', 'Category_Name', 'Description'];
    
    public function risks()
    {
        return $this->hasMany(Risk::class, 'Category_ID', 'Category_ID');
    }
}