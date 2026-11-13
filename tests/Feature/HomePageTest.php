<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_homepage_renders_the_project_identity(): void
    {
        $this->get('/')->assertOk()->assertSee('English Literacy Lab')->assertSee('ISL-first');
    }

    public function test_health_endpoint_is_available(): void
    {
        $this->get('/up')->assertOk();
    }
}
