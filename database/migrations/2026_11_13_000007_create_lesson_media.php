<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('lesson_media',function(Blueprint $table){
   $table->id(); $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
   $table->string('kind',20); $table->string('path')->nullable();
   $table->string('external_url',2048)->nullable();
   $table->string('title',150); $table->text('alt_text')->nullable();
   $table->longText('transcript')->nullable(); $table->string('language',20)->default('en');
   $table->unsignedInteger('sort_order')->default(0); $table->timestamps();
  });
 }
 public function down(): void {Schema::dropIfExists('lesson_media');}
};
