<?php

namespace Tests\Feature;

use Tests\TestCase;

class LinkedInLineBreakToolTest extends TestCase
{
    public function test_linkedin_line_break_generator_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.linkedin-line-break'));

        $response->assertStatus(200);
        $response->assertSee('Free LinkedIn Line Break Formatter', false);
        $response->assertSee('lineBreakFormatter()', false);
        $response->assertSee('rawText', false);
        $response->assertSee('formattedText', false);
        $response->assertSee('paragraphCount', false);
        $response->assertSee('injectedCount', false);
        $response->assertSee('copyFormatted()', false);
        $response->assertSee('fallbackCopy()', false);
        $response->assertSee('\u200B', false);
    }
}
