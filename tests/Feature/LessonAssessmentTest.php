<?php
namespace Tests\Feature;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class LessonAssessmentTest extends TestCase {
 use RefreshDatabase;
 private function learner(string $email): User {
  return User::create(['name'=>'Learner','email'=>$email,'password'=>'password','is_active'=>true]);
 }
 private function lesson(bool $published=true): Lesson {
  return Lesson::create(['slug'=>'assessment-lesson','title'=>'Assessment Lesson','level'=>'Foundation','topic'=>'Grammar','learning_outcome'=>'Write a sentence','content'=>'Practice reading.','is_published'=>$published]);
 }
 public function test_assessment_scoring_and_private_results(): void {
  $lesson=$this->lesson();
  $a=$lesson->activities()->create(['prompt'=>'Greeting?','answer'=>'Hello']);
  $b=$lesson->activities()->create(['prompt'=>'Farewell?','answer'=>'Goodbye']);
  $learner=$this->learner('a@example.test');
  $other=$this->learner('b@example.test');
  $this->actingAs($learner)->get("/curriculum/{$lesson->id}/assessment")->assertOk()->assertSee('Greeting?');
  $this->post("/curriculum/{$lesson->id}/assessment",[
   'answers'=>[$a->id=>'  HELLO  ',$b->id=>'wrong'],
  ])->assertRedirect();
  $this->assertDatabaseHas('assessment_attempts',[
   'user_id'=>$learner->id,'lesson_id'=>$lesson->id,'score_percent'=>50,'mastery_status'=>'developing',
  ]);
  $this->get('/dashboard')->assertOk()->assertSee('50%');
  $this->actingAs($other)->get("/curriculum/{$lesson->id}/assessment")->assertOk()->assertSee('No assessment attempts yet.');
  $this->get('/dashboard')->assertDontSee('50%');
 }
 public function test_guests_and_draft_lessons_are_protected(): void {
  $lesson=$this->lesson(false);
  $this->get("/curriculum/{$lesson->id}/assessment")->assertRedirect('/login');
  $this->actingAs($this->learner('c@example.test'))->get("/curriculum/{$lesson->id}/assessment")->assertNotFound();
  $this->post("/curriculum/{$lesson->id}/assessment",['answers'=>[]])->assertNotFound();
 }
 public function test_flashcards_are_not_assessment_questions(): void {
  $lesson=$this->lesson();
  $lesson->activities()->create(['prompt'=>'Reveal','answer'=>'Hello','activity_type'=>'flashcard']);
  $this->actingAs($this->learner('d@example.test'))->get("/curriculum/{$lesson->id}/assessment")->assertSee('no assessment questions');
 }
}
