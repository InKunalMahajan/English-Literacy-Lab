<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LessonMediaTest extends TestCase
{
    use RefreshDatabase;

    private function user(bool $editor): User
    {
        $user=User::create(['name'=>'Test','email'=>($editor?'editor':'learner').'@example.test','password'=>'password','is_active'=>true]);
        $user->forceFill(['is_content_editor'=>$editor])->save();
        return $user;
    }

    private function lesson(bool $published=false): Lesson
    {
        return Lesson::create(['slug'=>'visual-lesson','title'=>'Visual Lesson','level'=>'Foundation','topic'=>'Vocabulary','learning_outcome'=>'Recognise words','content'=>'Read the words','is_published'=>$published]);
    }

    public function test_editor_can_upload_accessible_image_and_draft_is_private(): void
    {
        Storage::fake('local');
        $lesson=$this->lesson();
        $editor=$this->user(true);
        $this->actingAs($editor)->post("/authoring/lessons/{$lesson->id}/media",[
            'kind'=>'image','title'=>'Greeting picture','alt_text'=>'A person waving hello',
            'language'=>'en','image'=>UploadedFile::fake()->image('greeting.png'),
        ])->assertRedirect();
        $media=$lesson->media()->firstOrFail();
        Storage::disk('local')->assertExists($media->path);
        $this->get("/media/{$media->id}")->assertOk();
        auth()->logout();
        $this->get("/media/{$media->id}")->assertNotFound();
        $lesson->update(['is_published'=>true]);
        $this->get("/media/{$media->id}")->assertOk();
        $this->get("/curriculum/{$lesson->id}")->assertSee('A person waving hello');
    }

    public function test_non_editor_cannot_upload_and_video_requires_transcript(): void
    {
        $lesson=$this->lesson();
        $this->actingAs($this->user(false))->post("/authoring/lessons/{$lesson->id}/media",[
            'kind'=>'video_link','title'=>'ISL Greetings','language'=>'en',
            'external_url'=>'https://example.com/video',
            'transcript'=>'The signer explains greetings.',
        ])->assertForbidden();
        auth()->logout();
        $this->actingAs($this->user(true))->post("/authoring/lessons/{$lesson->id}/media",[
            'kind'=>'video_link','title'=>'ISL Greetings','language'=>'en',
            'external_url'=>'https://example.com/video',
        ])->assertSessionHasErrors('transcript');
    }

    public function test_deleting_media_removes_its_file(): void
    {
        Storage::fake('local');
        $lesson=$this->lesson();
        $this->actingAs($this->user(true))->post("/authoring/lessons/{$lesson->id}/media",[
            'kind'=>'image','title'=>'Object','alt_text'=>'A cup','language'=>'en',
            'image'=>UploadedFile::fake()->image('cup.png'),
        ]);
        $media=$lesson->media()->firstOrFail();
        $path=$media->path;
        $this->delete("/authoring/media/{$media->id}",['confirmation'=>'DELETE'])->assertRedirect();
        Storage::disk('local')->assertMissing($path);
    }
}
