<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lesson_activities', function (Blueprint $table) {
            $table->string('activity_type', 24)->default('short_answer');
            $table->text('visual_prompt')->nullable();
        });
        Schema::create('learner_activity_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_activity_id')->constrained('lesson_activities')->cascadeOnDelete();
            $table->unsignedInteger('attempts')->default(0);
            $table->boolean('is_correct')->default(false);
            $table->timestamp('last_attempted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'lesson_activity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learner_activity_progress');
        Schema::table('lesson_activities', function (Blueprint $table) {
            $table->dropColumn(['activity_type','visual_prompt']);
        });
    }
};
