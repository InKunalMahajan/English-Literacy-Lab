<?php

namespace Tests\Feature;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurriculumTest extends TestCase
{
    use RefreshDatabase;

    private function lesson(string $slug, bool $published): Lesson
    {
        return Lesson::create([
            'slug' => $slug,
            'title' => 'Everyday English',
            'level' => 'Foundation',
            'topic' => 'Vocabulary',
            'learning_outcome' => 'Identify everyday words.',
            'content' => 'Look at the word and practise using it.',
            'isl_guidance' => 'Use a clear visual example before showing the written word.',
            'is_published' => $published,
        ]);
    }

    public function test_guests_can_browse_published_lessons(): void
    {
        $published = $this->lesson('everyday-english', true);
        $this->get('/curriculum')->assertOk()->assertSee('Everyday English');
        $this->get('/curriculum/'.$published->id)->assertOk()->assertSee('Indian Sign Language guidance');
    }

    public function test_draft_lessons_are_not_public(): void
    {
        $draft = $this->lesson('draft-english', false);
        $this->get('/curriculum')->assertOk()->assertDontSee('Everyday English');
        $this->get('/curriculum/'.$draft->id)->assertNotFound();
    }
}
