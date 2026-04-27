<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id('Policy_ID');
            $table->foreignId('Created_by')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Policy_Title', 100);
            $table->text('Description');
            $table->timestamp('Created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};