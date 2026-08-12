<?php

namespace Tests\Feature;

use Tests\TestCase;

class LinkedInPostPreviewToolTest extends TestCase
{
    public function test_linkedin_post_preview_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.linkedin-preview'));

        $response->assertStatus(200);
        $response->assertSee('LinkedIn Post Preview', false);
        $response->assertSee('linkedinPreview()', false);
        $response->assertSee('charLimit', false);
        $response->assertSee('lineLimit', false);
        $response->assertSee('isCutoff', false);
        $response->assertSee('cleanWhitespace', false);
        $response->assertSee('fallbackCopy', false);
    }
}
