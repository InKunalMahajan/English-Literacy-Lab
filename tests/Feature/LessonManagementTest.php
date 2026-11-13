<?php

namespace Tests\Feature;

use App\Models\CurriculumModule;
use App\Models\CurriculumUnit;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonManagementTest extends TestCase
{
    use RefreshDatabase;

    private function editor(bool $enabled): User
    {
        $user=User::create(['name'=>'Editor','email'=>($enabled?'editor':'learner').'@example.test','password'=>'password','is_active'=>true]);
        $user->forceFill(['is_content_editor'=>$enabled])->save();
        return $user;
    }

    private function lesson(): Lesson
    {
        $module=CurriculumModule::create(['title'=>'English','slug'=>'english']);
        $unit=CurriculumUnit::create(['curriculum_module_id'=>$module->id,'title'=>'Words','slug'=>'words']);
        return Lesson::create([
            'curriculum_unit_id'=>$unit->id,'slug'=>'hello','title'=>'Hello','level'=>'Foundation',
            'topic'=>'Vocabulary','learning_outcome'=>'Identify a greeting',
            'content'=>'Hello is a greeting','is_published'=>true,
        ]);
    }

    public function test_learner_cannot_edit_or_delete(): void
    {
        $lesson=$this->lesson();
        $this->actingAs($this->editor(false))->get("/authoring/lessons/{$lesson->id}/edit")->assertForbidden();
        $this->delete("/authoring/lessons/{$lesson->id}",['confirmation'=>'DELETE'])->assertForbidden();
        $this->assertDatabaseHas('lessons',['id'=>$lesson->id]);
    }

    public function test_editor_can_update_and_confirm_delete(): void
    {
        $lesson=$this->lesson();
        $this->actingAs($this->editor(true))->get("/authoring/lessons/{$lesson->id}/edit")->assertOk();
        $this->put("/authoring/lessons/{$lesson->id}",[
            'curriculum_unit_id'=>$lesson->curriculum_unit_id,'title'=>'Hello Again',
            'level'=>'Foundation','topic'=>'Vocabulary','learning_outcome'=>'Use a greeting',
            'content'=>'Hello again is a greeting',
        ])->assertRedirect('/authoring');
        $this->assertDatabaseHas('lessons',['id'=>$lesson->id,'slug'=>'hello-again']);
        $this->delete("/authoring/lessons/{$lesson->id}",['confirmation'=>'NO'])->assertStatus(422);
        $this->delete("/authoring/lessons/{$lesson->id}",['confirmation'=>'DELETE'])->assertRedirect('/authoring');
        $this->assertDatabaseMissing('lessons',['id'=>$lesson->id]);
    }
}
