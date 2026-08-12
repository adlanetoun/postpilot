<?php

namespace Tests\Feature;

use Tests\TestCase;

class LinkedInHookTemplatesToolTest extends TestCase
{
    public function test_linkedin_hook_templates_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.linkedin-hooks'));

        $response->assertStatus(200);
        $response->assertSee('LinkedIn Hook Generator Template Matrix', false);
        $response->assertSee('hookTemplates()', false);
        $response->assertSee('SaaS Marketing', false);
        $response->assertSee('contrarian', false);
        $response->assertSee('story', false);
        $response->assertSee('curiosity', false);
        $response->assertSee('copyHook(', false);
        $response->assertSee('copyAllFiltered()', false);
        $response->assertSee('filteredHooks', false);
        $response->assertSee('renderHook(', false);
    }
}
