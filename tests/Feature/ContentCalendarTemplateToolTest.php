<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContentCalendarTemplateToolTest extends TestCase
{
    public function test_30_day_content_calendar_template_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.content-calendar-template'));

        $response->assertStatus(200);
        $response->assertSee('30-Day Content Matrix Calendar Generator', false);
        $response->assertSee('calendarGenerator()', false);
        $response->assertSee('generateCalendar()', false);
        $response->assertSee('exportCsv()', false);
        $response->assertSee('pillarCounts', false);
        $response->assertSee('filteredDays', false);
        $response->assertSee('Educational', false);
        $response->assertSee('Proof', false);
        $response->assertSee('Story', false);
        $response->assertSee('Offer', false);
        $response->assertSee('\uFEFF', false);
        $response->assertSee('W1', false);
    }
}
