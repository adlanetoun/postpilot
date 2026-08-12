<?php

namespace Tests\Feature;

use Tests\TestCase;

class UtmBuilderTest extends TestCase
{
    /**
     * Test that the UTM Link Builder tool page loads successfully and contains Alpine component markup.
     */
    public function test_utm_builder_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.utm-builder'));

        $response->assertStatus(200);
        $response->assertSee('GA4 UTM Link Builder &amp; Parameter Generator', false);
        $response->assertSee('x-data="utmBuilder()"', false);
        $response->assertSee('utm_source');
        $response->assertSee('utm_medium');
        $response->assertSee('utm_campaign');
        $response->assertSee('utm_content');
        $response->assertSee('utm_term');
        $response->assertSee('Clean GA4 formatting');
    }

    /**
     * Test that the page contains all preset buttons and Alpine logic methods.
     */
    public function test_utm_builder_page_contains_preset_buttons_and_logic_methods(): void
    {
        $response = $this->get(route('tools.utm-builder'));

        $response->assertStatus(200);
        $response->assertSee("setPreset('linkedin', 'social')", false);
        $response->assertSee("setPreset('twitter', 'social')", false);
        $response->assertSee("setPreset('facebook', 'social')", false);
        $response->assertSee("setPreset('instagram', 'social')", false);
        $response->assertSee("setPreset('google', 'cpc')", false);
        $response->assertSee("setPreset('newsletter', 'email')", false);
        $response->assertSee('isPresetActive', false);
        $response->assertSee('cleanParam', false);
        $response->assertSee('generatedUrl', false);
        $response->assertSee('copyUrl', false);
    }

    /**
     * Test that the page renders the GA4 UTM Parameters Quick Reference section.
     */
    public function test_utm_builder_page_contains_quick_reference_guide(): void
    {
        $response = $this->get(route('tools.utm-builder'));

        $response->assertStatus(200);
        $response->assertSee('GA4 UTM Parameters Quick Reference');
        $response->assertSee('Identifies the platform or site referring traffic');
        $response->assertSee('Identifies the channel or medium type');
        $response->assertSee('Identifies the specific promotion or product campaign');
    }
}
