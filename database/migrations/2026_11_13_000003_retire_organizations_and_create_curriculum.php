<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('organization_memberships');
        Schema::dropIfExists('organizations');

        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('level', 32);
            $table->string('topic', 80);
            $table->text('learning_outcome');
            $table->longText('content');
            $table->text('isl_guidance')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            $table->index(['is_published', 'level', 'topic']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
        Schema::create('organizations', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::create('organization_memberships', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('role', 32);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['organization_id', 'user_id']);
            $table->index(['organization_id', 'role', 'is_active']);
        });
    }
};
