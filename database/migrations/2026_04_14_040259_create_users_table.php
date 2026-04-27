<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('User_ID');
            $table->foreignId('Role_ID')->constrained('roles', 'Role_ID')->onDelete('cascade');
            $table->string('Name', 100);
            $table->string('Email', 100)->unique();
            $table->string('Password', 255);
            $table->string('Status', 20)->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};