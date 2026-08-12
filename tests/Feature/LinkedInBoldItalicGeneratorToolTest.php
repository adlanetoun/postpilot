<?php

namespace Tests\Feature;

use Tests\TestCase;

class LinkedInBoldItalicGeneratorToolTest extends TestCase
{
    /**
     * Test that the LinkedIn Bold & Italic Generator page loads successfully.
     */
    public function test_linkedin_bold_italic_generator_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.linkedin-bold-italic'));

        $response->assertStatus(200);
        $response->assertSee('LinkedIn Bold &amp; Italic Unicode Text Generator', false);
        $response->assertSee('unicodeFormatter()', false);
        $response->assertSee('boldSerif', false);
        $response->assertSee('italicSerif', false);
        $response->assertSee('boldSans', false);
        $response->assertSee('italicSans', false);
        $response->assertSee('boldItalicSerif', false);
        $response->assertSee('monospace', false);
        $response->assertSee('script', false);
        $response->assertSee('boldScript', false);
        $response->assertSee('fallbackCopy', false);
    }

    /**
     * Test that the blade view contains all 8 styled Unicode cards and brutalist UI elements.
     */
    public function test_linkedin_bold_italic_generator_tool_contains_all_styled_cards(): void
    {
        $response = $this->get(route('tools.linkedin-bold-italic'));

        $response->assertStatus(200);
        $response->assertSee('Bold Serif', false);
        $response->assertSee('Italic Serif', false);
        $response->assertSee('Bold Sans-Serif', false);
        $response->assertSee('Italic Sans-Serif', false);
        $response->assertSee('Bold Italic Serif', false);
        $response->assertSee('Monospace', false);
        $response->assertSee('Script (Cursive)', false);
        $response->assertSee('Bold Script', false);
        $response->assertSee('100% FREE &amp; CLIENT-SIDE', false);
    }

    /**
     * Test that BMP exception mappings and Planck constant exception comments exist in the Alpine component logic.
     */
    public function test_linkedin_bold_italic_generator_tool_contains_bmp_exceptions(): void
    {
        $response = $this->get(route('tools.linkedin-bold-italic'));

        $response->assertStatus(200);
        $response->assertSee('0x210E', false); // Planck constant for 'h'
        $response->assertSee('0x212C', false); // Script B
        $response->assertSee('0x2130', false); // Script E
        $response->assertSee('0x2131', false); // Script F
        $response->assertSee('0x210B', false); // Script H
        $response->assertSee('0x2110', false); // Script I
        $response->assertSee('0x2112', false); // Script L
        $response->assertSee('0x2133', false); // Script M
        $response->assertSee('0x211B', false); // Script R
        $response->assertSee('0x212F', false); // Script e
        $response->assertSee('0x210A', false); // Script g
        $response->assertSee('0x2134', false); // Script o
    }
}
