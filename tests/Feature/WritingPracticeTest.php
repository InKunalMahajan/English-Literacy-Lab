<?php
namespace Tests\Feature;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class WritingPracticeTest extends TestCase {
 use RefreshDatabase;
 private function lesson(bool $published=true): Lesson {
  return Lesson::create(['slug'=>'read-write','title'=>'Read and Write','level'=>'Foundation','topic'=>'Reading','learning_outcome'=>'Write a paragraph','content'=>'A short reading passage.','is_published'=>$published]);
 }
 private function learner(string $email): User {
  return User::create(['name'=>'Learner','email'=>$email,'password'=>'password','is_active'=>true]);
 }
 public function test_writing_is_saved_updated_and_private(): void {
  $lesson=$this->lesson();
  $a=$this->learner('a@example.test');$b=$this->learner('b@example.test');
  $this->actingAs($a)->post("/curriculum/{$lesson->id}/writing",['response'=>'I read a book.'])->assertRedirect();
  $this->post("/curriculum/{$lesson->id}/writing",['response'=>'I read two books.'])->assertRedirect();
  $this->assertDatabaseCount('writing_practice',1);
  $this->assertDatabaseHas('writing_practice',['user_id'=>$a->id,'lesson_id'=>$lesson->id,'response'=>'I read two books.']);
  $this->get("/curriculum/{$lesson->id}")->assertSee('I read two books.');
  $this->actingAs($b)->get("/curriculum/{$lesson->id}")->assertDontSee('I read two books.');
  $this->get('/dashboard')->assertOk()->assertSee('No writing drafts saved yet.');
 }
 public function test_guests_and_draft_lessons_cannot_save_writing(): void {
  $lesson=$this->lesson();
  $this->post("/curriculum/{$lesson->id}/writing",['response'=>'Hello'])->assertRedirect('/login');
  $lesson->update(['is_published'=>false]);
  $this->actingAs($this->learner('c@example.test'))->post("/curriculum/{$lesson->id}/writing",['response'=>'Hello'])->assertNotFound();
 }
}
