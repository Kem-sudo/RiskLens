<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_attachments', function (Blueprint $table) {
            $table->id('Attachment_ID');
            $table->foreignId('Incident_ID')->constrained('incidents', 'Incident_ID')->onDelete('cascade');
            $table->string('File_Path', 255);
            $table->timestamp('Uploaded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_attachments');
    }
};