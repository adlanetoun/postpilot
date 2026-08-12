<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class CampaignWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_connect_and_disconnect_mock_social_accounts()
    {
        $user = User::factory()->create();
        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Test Project',
            'description' => 'Test Description',
            'platforms' => ['linkedin'],
        ]);

        // Mock the Socialite User returned by the callback
        $oauthUser = \Mockery::mock('Laravel\Socialite\Two\User');
        $oauthUser->shouldReceive('getId')->andReturn('mock_li_123');
        $oauthUser->shouldReceive('getName')->andReturn('Test LI User');
        $oauthUser->shouldReceive('getNickname')->andReturn('test_li_user');
        $oauthUser->token = 'mock_access_token_123';
        $oauthUser->refreshToken = 'mock_refresh_token_123';
        $oauthUser->expiresIn = 3600;

        // Mock the Socialite Provider with scopes, redirect, and user methods
        $provider = \Mockery::mock('Laravel\Socialite\Two\AbstractProvider');
        $provider->shouldReceive('scopes')->andReturnSelf();
        $provider->shouldReceive('redirect')->andReturn(redirect('https://linkedin.com/oauth'));
        $provider->shouldReceive('user')->andReturn($oauthUser);

        Socialite::shouldReceive('driver')
            ->with('linkedin')
            ->andReturn($provider);

        // 1. Redirect to provider via signed route
        $url = URL::signedRoute('social-accounts.connect', ['project' => $project->id, 'platform' => 'linkedin']);
        $response = $this->actingAs($user)->get($url);

        // Since postpeer isn't mocked in this basic test, it returns view or redirect; just verify it passed auth/signature check (not 403)
        $this->assertNotEquals(403, $response->getStatusCode());

        // 2. Disconnect provider
        $response = $this->actingAs($user)
            ->delete(route('social-accounts.disconnect', ['project' => $project->id, 'platform' => 'linkedin']));

        $response->assertRedirect(route('projects.show', $project->id));
    }

    public function test_user_can_approve_campaign_and_stagger_posts()
    {
        $user = User::factory()->create([
            'timezone' => 'America/New_York',
            'campaign_credits' => 10,
        ]);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Test Project',
            'description' => 'Test Description',
            'target_audience' => 'Audience',
            'platforms' => ['linkedin', 'twitter'],
        ]);

        // Connect some accounts at project level
        $user->socialAccounts()->create([
            'project_id' => $project->id,
            'provider' => 'linkedin',
            'provider_user_id' => 'mock_li_123',
            'username' => 'Mock LI',
            'access_token' => 'token',
        ]);
        $user->socialAccounts()->create([
            'project_id' => $project->id,
            'provider' => 'twitter',
            'provider_user_id' => 'mock_tw_123',
            'username' => 'Mock TW',
            'access_token' => 'token',
        ]);

        $campaign = Campaign::create([
            'project_id' => $project->id,
            'status' => 'completed',
        ]);

        // Create posts for linkedin and twitter
        $post1 = Post::create([
            'campaign_id' => $campaign->id,
            'platform' => 'linkedin',
            'content' => 'Post content linkedin',
            'day_number' => 1,
            'status' => 'pending',
        ]);
        $post2 = Post::create([
            'campaign_id' => $campaign->id,
            'platform' => 'twitter',
            'content' => 'Post content twitter',
            'day_number' => 1,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)
            ->post(route('campaigns.approve', $campaign->id));

        $response->assertRedirect(route('projects.show', $project->id));

        $campaign->refresh();
        $this->assertEquals('active', $campaign->status);

        $post1->refresh();
        $post2->refresh();

        $this->assertEquals('approved', $post1->status);
        $this->assertEquals('approved', $post2->status);

        $this->assertNotNull($post1->scheduled_at);
        $this->assertNotNull($post2->scheduled_at);

        // Check platform link
        $this->assertNotNull($post1->social_account_id);
        $this->assertNotNull($post2->social_account_id);

        // Stagger checking: New York time should start tomorrow around 09:00 for LinkedIn (+/- 10m jitter), and around 09:15 for X/Twitter
        $nyTime1 = $post1->scheduled_at->timezone('America/New_York');
        $nyTime2 = $post2->scheduled_at->timezone('America/New_York');

        $startOfDay = $nyTime1->copy()->startOfDay();
        $this->assertTrue($nyTime1->gte($startOfDay->copy()->addHours(8)->addMinutes(45)));
        $this->assertTrue($nyTime1->lte($startOfDay->copy()->addHours(9)->addMinutes(15)));

        $this->assertTrue($nyTime2->gte($startOfDay->copy()->addHours(9)->addMinutes(0)));
        $this->assertTrue($nyTime2->lte($startOfDay->copy()->addHours(9)->addMinutes(30)));
    }

    public function test_publish_scheduled_posts_command()
    {
        $user = User::factory()->create();

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Publishing Project',
            'description' => 'Desc',
            'platforms' => ['linkedin'],
        ]);

        $user->socialAccounts()->create([
            'project_id' => $project->id,
            'provider' => 'linkedin',
            'provider_user_id' => 'mock_li_123',
            'username' => 'Mock LI',
            'access_token' => 'mock_token',
        ]);

        $campaign = Campaign::create([
            'project_id' => $project->id,
            'status' => 'active',
        ]);

        $post = Post::create([
            'campaign_id' => $campaign->id,
            'platform' => 'linkedin',
            'content' => 'Hello LinkedIn!',
            'day_number' => 1,
            'status' => 'approved',
            'scheduled_at' => now()->subMinutes(5),
            'social_account_id' => $user->socialAccounts()->first()->id,
        ]);

        $this->artisan('app:publish-scheduled-posts')
            ->assertExitCode(0);

        $post->refresh();
        $this->assertEquals('published', $post->status);
        $this->assertNotNull($post->published_at);
        $this->assertNotNull($post->platform_post_id);
    }
}
