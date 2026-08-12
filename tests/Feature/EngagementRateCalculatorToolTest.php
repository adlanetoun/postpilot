<?php

namespace Tests\Feature;

use Tests\TestCase;

class EngagementRateCalculatorToolTest extends TestCase
{
    /**
     * Test that the engagement rate calculator tool route loads successfully.
     */
    public function test_engagement_rate_calculator_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.engagement-calculator'));

        $response->assertStatus(200);
        $response->assertSee('Social Media Engagement Rate Calculator', false);
        $response->assertSee('engagementCalc()', false);
        $response->assertSee('followersCount', false);
        $response->assertSee('likesCount', false);
        $response->assertSee('commentsCount', false);
        $response->assertSee('sharesCount', false);
        $response->assertSee('totalInteractions', false);
        $response->assertSee('indicatorPosition', false);
        $response->assertSee('benchmarkText', false);
    }

    /**
     * Test that the blade view includes the correct letter grade evaluation rules and benchmark scaling.
     */
    public function test_engagement_rate_calculator_blade_contains_logic_elements(): void
    {
        $response = $this->get(route('tools.engagement-calculator'));

        $response->assertStatus(200);
        // Letter grade thresholds assertion
        $response->assertSee("if (r >= 4.0) return 'A+';", false);
        $response->assertSee("if (r >= 2.5) return 'A';", false);
        $response->assertSee("if (r >= 1.5) return 'B';", false);
        $response->assertSee("if (r >= 0.8) return 'C';", false);
        $response->assertSee("if (r >= 0.3) return 'D';", false);
        $response->assertSee("return 'F';", false);
        // Division by zero protection assertion
        $response->assertSee('if (f <= 0) return 0;', false);
        $response->assertSee('Enter your follower or connection count to calculate your engagement rate benchmark.', false);
    }
}
