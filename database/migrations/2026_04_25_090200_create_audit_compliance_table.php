<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_compliance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Audit_ID')->constrained('audits', 'Audit_ID')->onDelete('cascade');
            $table->foreignId('Compliance_ID')->constrained('compliance', 'Compliance_ID')->onDelete('cascade');
            $table->unique(['Audit_ID', 'Compliance_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_compliance');
    }
};
