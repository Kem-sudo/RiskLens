<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id('Incident_ID');
            $table->foreignId('Reported_by')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Incident_Title', 100);
            $table->text('Description');
            $table->string('Status', 20);
            $table->timestamp('Reported_Date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};