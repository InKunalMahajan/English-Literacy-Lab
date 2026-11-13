<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonCompletionTest extends TestCase
{
    use RefreshDatabase;

    private function learner(string $email): User
    {
        return User::create(['name'=>'Learner','email'=>$email,'password'=>'password','is_active'=>true]);
    }

    private function lesson(bool $published=true): Lesson
    {
        return Lesson::create([
            'slug'=>'greetings','title'=>'Greetings','level'=>'Foundation',
            'topic'=>'Vocabulary','learning_outcome'=>'Use greetings',
            'content'=>'Say hello.','is_published'=>$published,
        ]);
    }

    public function test_completion_requires_correct_answers_and_is_individual(): void
    {
        $lesson=$this->lesson();
        $activity=$lesson->activities()->create(['prompt'=>'Write hello','answer'=>'hello']);
        $a=$this->learner('a@example.test');
        $b=$this->learner('b@example.test');
        $this->actingAs($a)->post("/curriculum/{$lesson->id}/complete")->assertSessionHasErrors('completion');
        $this->post("/activities/{$activity->id}/check",['answer'=>'hello'])->assertRedirect();
        $this->post("/curriculum/{$lesson->id}/complete")->assertSessionHas('status');
        $this->post("/curriculum/{$lesson->id}/complete")->assertSessionHas('status');
        $this->assertDatabaseCount('lesson_completions',1);
        $this->get('/dashboard')->assertOk()->assertSee('1 / 1');
        $this->actingAs($b)->get('/dashboard')->assertOk()->assertSee('0 / 1');
        $this->post("/curriculum/{$lesson->id}/complete")->assertSessionHasErrors('completion');
    }

    public function test_draft_lessons_cannot_be_completed(): void
    {
        $lesson=$this->lesson(false);
        $this->actingAs($this->learner('c@example.test'))
            ->post("/curriculum/{$lesson->id}/complete")->assertNotFound();
    }

    public function test_guest_cannot_mark_lesson_complete(): void
    {
        $lesson=$this->lesson();
        $this->post("/curriculum/{$lesson->id}/complete")->assertRedirect('/login');
    }
}
