<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policy_acknowledgments', function (Blueprint $table) {
            $table->id('Acknowledgment_ID');
            $table->foreignId('Policy_ID')->constrained('policies', 'Policy_ID')->onDelete('cascade');
            $table->foreignId('User_ID')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->timestamp('Acknowledged_at')->useCurrent();
            $table->unique(['Policy_ID', 'User_ID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policy_acknowledgments');
    }
};
