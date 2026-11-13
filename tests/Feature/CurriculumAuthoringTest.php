<?php

namespace Tests\Feature;

use App\Models\CurriculumModule;
use App\Models\CurriculumUnit;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurriculumAuthoringTest extends TestCase
{
    use RefreshDatabase;

    private function user(bool $editor): User
    {
        return User::create([
            'name'=>'Test Educator',
            'email'=>($editor ? 'editor' : 'learner').'@example.test',
            'password'=>'password',
            'is_active'=>true,
            'is_content_editor'=>$editor,
        ]);
    }

    public function test_only_editors_can_author_curriculum(): void
    {
        $this->get('/authoring')->assertRedirect('/login');
        $this->actingAs($this->user(false))->get('/authoring')->assertForbidden();
        $this->post('/authoring/modules',['title'=>'Grammar'])->assertForbidden();
    }

    public function test_editor_can_create_module_unit_draft_lesson_and_publish(): void
    {
        $this->actingAs($this->user(true))->get('/authoring')->assertOk();
        $this->post('/authoring/modules',['title'=>'Everyday English'])->assertRedirect();
        $module=CurriculumModule::firstOrFail();
        $this->post('/authoring/units',['curriculum_module_id'=>$module->id,'title'=>'Greetings'])->assertRedirect();
        $unit=CurriculumUnit::firstOrFail();
        $this->post('/authoring/lessons',[
            'curriculum_unit_id'=>$unit->id,'title'=>'Say Hello','level'=>'Foundation',
            'topic'=>'Vocabulary','learning_outcome'=>'Identify a greeting',
            'content'=>'Hello is a greeting.','isl_guidance'=>'Show the meaning visually.',
            'is_published'=>1,
        ])->assertRedirect();
        $lesson=Lesson::firstOrFail();
        $this->assertFalse($lesson->is_published);
        $this->get('/curriculum/'.$lesson->id)->assertNotFound();
        $this->post('/authoring/lessons/'.$lesson->id.'/activities',[
            'prompt'=>'Write the greeting','answer'=>'Hello','hint'=>'Five letters',
        ])->assertRedirect();
        $this->post('/authoring/lessons/'.$lesson->id.'/publish')->assertRedirect();
        $this->get('/curriculum/'.$lesson->id)->assertOk()->assertSee('Write the greeting');
        $this->post('/activities/'.$lesson->activities()->firstOrFail()->id.'/check',[
            'answer'=>'hello',
        ])->assertRedirect()->assertSessionHas('activity_feedback');
    }

    public function test_unpublished_activity_is_not_accessible(): void
    {
        $lesson=Lesson::create([
            'slug'=>'private-lesson','title'=>'Private Lesson','level'=>'Foundation',
            'topic'=>'Reading','learning_outcome'=>'Read','content'=>'Draft',
            'is_published'=>false,
        ]);
        $activity=$lesson->activities()->create(['prompt'=>'Question','answer'=>'Secret']);
        $this->post('/activities/'.$activity->id.'/check',['answer'=>'Secret'])->assertNotFound();
    }
}
