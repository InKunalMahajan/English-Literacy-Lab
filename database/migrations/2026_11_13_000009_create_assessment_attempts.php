<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('assessment_attempts',function(Blueprint $table){
   $table->id();$table->foreignId('user_id')->constrained()->cascadeOnDelete();
   $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
   $table->unsignedInteger('total_questions');$table->unsignedInteger('correct_answers');
   $table->unsignedTinyInteger('score_percent');$table->string('mastery_status',30);
   $table->timestamp('submitted_at');$table->timestamps();
   $table->index(['user_id','lesson_id']);
  });
 }
 public function down(): void {Schema::dropIfExists('assessment_attempts');}
};
