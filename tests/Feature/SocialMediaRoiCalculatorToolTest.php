<?php

namespace Tests\Feature;

use Tests\TestCase;

class SocialMediaRoiCalculatorToolTest extends TestCase
{
    public function test_social_media_roi_calculator_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.social-roi-calculator'));

        $response->assertStatus(200);
        $response->assertSee('Social Media Time Saved &amp; ROI Calculator', false);
        $response->assertSee('roiCalculator()', false);
        $response->assertSee('postsPerWeek', false);
        $response->assertSee('minutesPerPost', false);
        $response->assertSee('hourlyRate', false);
        $response->assertSee('annualHoursLost', false);
        $response->assertSee('annualDollarsLost', false);
        $response->assertSee('autopilotHoursSaved', false);
        $response->assertSee('netRoiGain', false);
        $response->assertSee('safePostsPerWeek', false);
        $response->assertSee('safeMinutesPerPost', false);
        $response->assertSee('safeHourlyRate', false);
        $response->assertSee('setPreset', false);
    }
}
