<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityManagementTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $email, bool $editor): User
    {
        $user=User::create(['name'=>'Test','email'=>$email,'password'=>'password','is_active'=>true]);
        $user->forceFill(['is_content_editor'=>$editor])->save();
        return $user;
    }

    public function test_only_editor_can_change_activity_and_changes_reset_old_progress(): void
    {
        $lesson=Lesson::create(['slug'=>'hello','title'=>'Hello','level'=>'Foundation','topic'=>'Vocabulary','learning_outcome'=>'Recognise hello','content'=>'Hello','is_published'=>true]);
        $activity=$lesson->activities()->create(['prompt'=>'Say hello','answer'=>'hello']);
        $learner=$this->user('learner@example.test',false);
        $editor=$this->user('editor@example.test',true);

        $this->actingAs($learner)->put("/authoring/activities/{$activity->id}",[
            'prompt'=>'New prompt','answer'=>'hi','activity_type'=>'vocabulary','sort_order'=>1,
        ])->assertForbidden();
        $this->post("/activities/{$activity->id}/check",['answer'=>'hello'])->assertRedirect();
        $this->post("/curriculum/{$lesson->id}/complete")->assertSessionHas('status');
        $this->assertDatabaseCount('lesson_completions',1);

        $this->actingAs($editor)->get("/authoring/activities/{$activity->id}/edit")->assertOk();
        $this->put("/authoring/activities/{$activity->id}",[
            'prompt'=>'Write hi','answer'=>'hi','activity_type'=>'vocabulary','sort_order'=>1,
        ])->assertRedirect('/authoring');
        $this->assertDatabaseHas('lesson_activities',['id'=>$activity->id,'prompt'=>'Write hi']);
        $this->assertDatabaseCount('learner_activity_progress',0);
        $this->assertDatabaseCount('lesson_completions',0);
    }

    public function test_activity_deletion_requires_confirmation(): void
    {
        $lesson=Lesson::create(['slug'=>'hi','title'=>'Hi','level'=>'Foundation','topic'=>'Vocabulary','learning_outcome'=>'Learn hi','content'=>'Hi','is_published'=>true]);
        $activity=$lesson->activities()->create(['prompt'=>'Say hi','answer'=>'hi']);
        $this->actingAs($this->user('editor2@example.test',true))
            ->delete("/authoring/activities/{$activity->id}",['confirmation'=>'NO'])->assertSessionHasErrors('confirmation');
        $this->assertDatabaseHas('lesson_activities',['id'=>$activity->id]);
        $this->delete("/authoring/activities/{$activity->id}",['confirmation'=>'DELETE'])->assertRedirect('/authoring');
        $this->assertDatabaseMissing('lesson_activities',['id'=>$activity->id]);
    }
}
