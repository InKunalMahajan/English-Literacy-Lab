<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('research_consents',function(Blueprint $table){
   $table->id();$table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
   $table->string('policy_version',30);
   $table->timestamp('consented_at')->nullable();$table->timestamp('withdrawn_at')->nullable();
   $table->timestamps();
  });
 }
 public function down(): void {Schema::dropIfExists('research_consents');}
};
