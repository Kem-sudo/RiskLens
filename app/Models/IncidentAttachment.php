<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentAttachment extends Model
{
    protected $primaryKey = 'Attachment_ID';
    protected $table = 'incident_attachments';
    
    protected $fillable = ['Attachment_ID', 'Incident_ID', 'File_Path', 'Uploaded_at'];
    
    public $timestamps = false;
    
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'Incident_ID', 'Incident_ID');
    }
}