<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InteractiveActivitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_flashcard_and_sentence_ordering_render_and_accept_answers(): void
    {
        $lesson=Lesson::create([
            'slug'=>'sentences','title'=>'Build Sentences','level'=>'Foundation',
            'topic'=>'Grammar','learning_outcome'=>'Write a complete sentence',
            'content'=>'Arrange words.','is_published'=>true,
        ]);
        $card=$lesson->activities()->create([
            'activity_type'=>'flashcard','prompt'=>'What word describes a greeting?',
            'answer'=>'Hello','visual_prompt'=>'A friend waves.',
        ]);
        $sentence=$lesson->activities()->create([
            'activity_type'=>'sentence_order','prompt'=>'Order: school / to / I / go',
            'answer'=>'I go to school',
        ]);
        $this->get("/curriculum/{$lesson->id}")->assertOk()
            ->assertSee('Reveal vocabulary card')->assertSee('Put the words in the correct order');
        $user=User::create(['name'=>'Learner','email'=>'learner@example.test','password'=>'password','is_active'=>true]);
        $this->actingAs($user)->post("/activities/{$sentence->id}/check",[
            'answer'=>' I   go to  school ',
        ])->assertSessionHas('activity_feedback');
        $this->assertDatabaseHas('learner_activity_progress',[
            'user_id'=>$user->id,'lesson_activity_id'=>$sentence->id,'is_correct'=>1,
        ]);
    }
}
