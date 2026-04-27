<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $primaryKey = 'Audit_ID';
    protected $table = 'audits';
    
    protected $fillable = ['Audit_ID', 'Auditor_ID', 'Audit_Title', 'Findings', 'Audit_Date', 'Status'];

    public $timestamps = true;
    
    public function auditor()
    {
        return $this->belongsTo(User::class, 'Auditor_ID', 'User_ID');
    }

    public function complianceItems()
    {
        return $this->belongsToMany(
            Compliance::class,
            'audit_compliance',
            'Audit_ID',
            'Compliance_ID',
            'Audit_ID',
            'Compliance_ID'
        );
    }
}