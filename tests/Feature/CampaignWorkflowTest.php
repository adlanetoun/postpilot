<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CampaignWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_connect_and_disconnect_mock_social_accounts()
    {
        $user = User::factory()->create();

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

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')
            ->with('linkedin')
            ->andReturn($provider);

        // 1. Redirect to provider
        $response = $this->actingAs($user)
            ->get(route('social-accounts.connect', 'linkedin'));

        $response->assertRedirect('https://linkedin.com/oauth');

        // 2. Handle provider callback
        $response = $this->actingAs($user)
            ->get(route('social-accounts.callback', 'linkedin'));

        $response->assertRedirect(route('profile.edit', ['tab' => 'socials']));
        
        $this->assertDatabaseHas('social_accounts', [
            'user_id' => $user->id,
            'provider' => 'linkedin',
            'provider_user_id' => 'mock_li_123',
            'username' => 'test_li_user',
        ]);

        // 3. Disconnect provider
        $response = $this->actingAs($user)
            ->delete(route('social-accounts.disconnect', 'linkedin'));

        $response->assertRedirect(route('profile.edit', ['tab' => 'socials']));
        $this->assertDatabaseMissing('social_accounts', [
            'user_id' => $user->id,
            'provider' => 'linkedin',
        ]);
    }

    public function test_user_can_approve_campaign_and_stagger_posts()
    {
        $user = User::factory()->create(['timezone' => 'America/New_York']);
        
        // Connect some accounts
        $user->socialAccounts()->create([
            'provider' => 'linkedin',
            'provider_user_id' => 'mock_li_123',
            'username' => 'Mock LI',
            'access_token' => 'token',
        ]);
        $user->socialAccounts()->create([
            'provider' => 'twitter',
            'provider_user_id' => 'mock_tw_123',
            'username' => 'Mock TW',
            'access_token' => 'token',
        ]);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Test Project',
            'description' => 'Test Description',
            'target_audience' => 'Audience',
            'platforms' => ['linkedin', 'twitter'],
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

        $response->assertRedirect(route('dashboard'));
        
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

        // Stagger checking: New York time should start tomorrow at 09:00 for LinkedIn, and 09:15 for X/Twitter
        $nyTime1 = $post1->scheduled_at->timezone('America/New_York');
        $nyTime2 = $post2->scheduled_at->timezone('America/New_York');

        $this->assertEquals('09:00:00', $nyTime1->format('H:i:s'));
        $this->assertEquals('09:15:00', $nyTime2->format('H:i:s'));
    }

    public function test_publish_scheduled_posts_command()
    {
        $user = User::factory()->create();
        
        $user->socialAccounts()->create([
            'provider' => 'linkedin',
            'provider_user_id' => 'mock_li_123',
            'username' => 'Mock LI',
            'access_token' => 'mock_token',
        ]);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => 'Publishing Project',
            'description' => 'Desc',
            'platforms' => ['linkedin'],
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
