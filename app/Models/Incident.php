<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $primaryKey = 'Incident_ID';
    protected $table = 'incidents';
    
    protected $fillable = ['Incident_ID', 'Reported_by', 'Incident_Title', 'Description', 'Status', 'Reported_Date'];
    
    public $timestamps = false;
    
    public function reporter()
    {
        return $this->belongsTo(User::class, 'Reported_by', 'User_ID');
    }
    
    public function attachments()
    {
        return $this->hasMany(IncidentAttachment::class, 'Incident_ID', 'Incident_ID');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->Status) {
            'Open' => 'danger',
            'In Progress' => 'warning',
            'Resolved' => 'success',
            'Closed' => 'secondary',
            default => 'dark',
        };
    }
}