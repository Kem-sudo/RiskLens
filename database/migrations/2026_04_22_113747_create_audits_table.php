<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audits', function (Blueprint $table) {
            $table->id('Audit_ID');
            $table->foreignId('Auditor_ID')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Audit_Title', 100);
            $table->text('Findings')->nullable();
            $table->date('Audit_Date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};