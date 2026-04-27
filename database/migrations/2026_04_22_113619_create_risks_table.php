<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id('RiskID');
            $table->foreignId('Category_ID')->constrained('risk_categories', 'Category_ID')->onDelete('cascade');
            $table->foreignId('Reported_by')->constrained('users', 'User_ID')->onDelete('cascade');
            $table->string('Risk_Title', 100);
            $table->enum('Risk_Level', ['Low', 'Medium', 'High', 'Critical'])->default('Low');
            $table->text('Description');
            $table->timestamp('Created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};