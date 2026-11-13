<?php

namespace Tests\Feature;

use App\Models\LearnerActivityProgress;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearnerProgressTest extends TestCase
{
    use RefreshDatabase;

    private function publishedActivity(): \App\Models\LessonActivity
    {
        $lesson = Lesson::create([
            'slug'=>'visual-greetings','title'=>'Visual Greetings','level'=>'Foundation',
            'topic'=>'Vocabulary','learning_outcome'=>'Recognise greetings',
            'content'=>'Use hello in context.','is_published'=>true,
        ]);
        return $lesson->activities()->create([
            'prompt'=>'Write a greeting','answer'=>'Hello',
            'activity_type'=>'vocabulary','visual_prompt'=>'A friend waves hello.',
        ]);
    }

    public function test_signed_in_learner_progress_is_saved_and_private(): void
    {
        $activity=$this->publishedActivity();
        $a=User::create(['name'=>'A','email'=>'a@example.test','password'=>'password','is_active'=>true]);
        $b=User::create(['name'=>'B','email'=>'b@example.test','password'=>'password','is_active'=>true]);

        $this->actingAs($a)->post("/activities/{$activity->id}/check",['answer'=>'wrong'])->assertRedirect();
        $this->post("/activities/{$activity->id}/check",['answer'=>' hello '])->assertRedirect();
        $this->assertDatabaseHas('learner_activity_progress',[
            'user_id'=>$a->id,'lesson_activity_id'=>$activity->id,'attempts'=>2,'is_correct'=>1,
        ]);
        $this->get("/curriculum/{$activity->lesson_id}")->assertOk()->assertSee('2 attempt(s)');
        $this->actingAs($b)->get("/curriculum/{$activity->lesson_id}")->assertOk()->assertDontSee('2 attempt(s)');
        $this->assertSame(1, LearnerActivityProgress::count());
    }

    public function test_guest_can_practise_without_persistent_progress(): void
    {
        $activity=$this->publishedActivity();
        $this->post("/activities/{$activity->id}/check",['answer'=>'Hello'])->assertRedirect();
        $this->assertSame(0, LearnerActivityProgress::count());
    }
}
