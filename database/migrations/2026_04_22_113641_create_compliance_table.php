<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compliance', function (Blueprint $table) {
            $table->id('Compliance_ID');
            $table->foreignId('PolicyID')->constrained('policies', 'Policy_ID')->onDelete('cascade');
            $table->foreignId('Checked_by')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Status', 20);
            $table->date('Review_Date');
            $table->text('Remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance');
    }
};