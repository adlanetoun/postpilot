<?php

namespace Tests\Feature;

use Tests\TestCase;

class TwitterThreadSplitterToolTest extends TestCase
{
    /**
     * Test that the X/Twitter Thread Splitter tool page loads successfully with expected content.
     */
    public function test_twitter_thread_splitter_tool_page_loads_successfully(): void
    {
        $response = $this->get(route('tools.twitter-thread-splitter'));

        $response->assertStatus(200);
        $response->assertSee('Free Twitter Thread Splitter [No Sign-Up]', false);
        $response->assertSee('x-data="twitterSplitter(', false);
        $response->assertSee('getTwitterLength', false);
        $response->assertSee('splitThread', false);
        $response->assertSee('doSplit', false);
        $response->assertSee('copyAllTweets', false);
        $response->assertSee('copySingleTweet', false);
        $response->assertSee('postToTwitter', false);
        $response->assertSee('numberFormat', false);
        $response->assertSee('numberPosition', false);
        $response->assertSee('STEP 1', false);
        $response->assertSee('STEP 2', false);
    }
}
