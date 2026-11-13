<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', fn (Blueprint $table) => $table->boolean('is_content_editor')->default(false));
        Schema::create('curriculum_modules', function (Blueprint $table) {
            $table->id(); $table->string('title'); $table->string('slug')->unique();
            $table->text('description')->nullable(); $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
        Schema::create('curriculum_units', function (Blueprint $table) {
            $table->id(); $table->foreignId('curriculum_module_id')->constrained('curriculum_modules')->cascadeOnDelete();
            $table->string('title'); $table->string('slug'); $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps(); $table->unique(['curriculum_module_id','slug']);
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('curriculum_unit_id')->nullable()->constrained('curriculum_units')->nullOnDelete();
            $table->string('isl_video_url')->nullable();
        });
        Schema::create('lesson_activities', function (Blueprint $table) {
            $table->id(); $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('prompt'); $table->string('answer'); $table->text('hint')->nullable();
            $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('lesson_activities');
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropConstrainedForeignId('curriculum_unit_id');
            $table->dropColumn('isl_video_url');
        });
        Schema::dropIfExists('curriculum_units'); Schema::dropIfExists('curriculum_modules');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('is_content_editor'));
    }
};
