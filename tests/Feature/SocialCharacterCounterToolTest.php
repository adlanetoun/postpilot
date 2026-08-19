<?php

namespace Tests\Feature;

use Tests\TestCase;

class SocialCharacterCounterToolTest extends TestCase
{
    public function test_social_character_counter_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.social-character-counter'));

        $response->assertStatus(200);
        $response->assertSee('Multi-Platform Social Character Limit Counter', false);
        $response->assertSee('x-data="socialCounter(', false);
        $response->assertSee('wordCount', false);
        $response->assertSee('sentenceCount', false);
        $response->assertSee('readTime', false);
        $response->assertSee('getPlatform(280, 240)', false);
        $response->assertSee('getPlatform(3000, 2700)', false);
        $response->assertSee('getPlatform(63206, 60000)', false);
        $response->assertSee('getPlatform(500, 450)', false);
        $response->assertSee("transformText('clean')", false);
        $response->assertSee("transformText('uppercase')", false);
        $response->assertSee("transformText('lowercase')", false);
        $response->assertSee("transformText('titlecase')", false);
    }

    public function test_social_character_counter_modifier_page_loads_successfully(): void
    {
        $response = $this->get('/tools/social-character-counter/for-threads');

        $response->assertStatus(200);
        $response->assertSee('Free Threads App Character Limit Counter', false);
        $response->assertSee('Meta Threads allows up to 500 characters', false);
    }
}
