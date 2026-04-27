<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id('Log_ID');
            $table->foreignId('User_ID')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Action', 100);
            $table->string('Module', 50);
            $table->timestamp('Timestamp')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};