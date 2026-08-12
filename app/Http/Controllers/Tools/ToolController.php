<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;

class ToolController extends Controller
{
    /**
     * Display the Free Satellite Tools Directory Index (/tools).
     */
    public function index()
    {
        return view('tools.index');
    }

    /**
     * 1. Free LinkedIn Post Preview & See More Checker
     */
    public function linkedinPreview()
    {
        return view('tools.linkedin-post-preview');
    }

    /**
     * 2. Free Twitter / X Thread Splitter & Auto-Numbering
     */
    public function twitterThreadSplitter($modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.twitter-thread-splitter.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.twitter-thread-splitter', compact('seo'));
    }

    /**
     * 3. Free LinkedIn Unicode Bold & Italic Text Generator
     */
    public function linkedinBoldItalic()
    {
        return view('tools.linkedin-bold-italic-generator');
    }

    /**
     * 4. Multi-Platform Social Character Limit Counter Grid
     */
    public function socialCharacterCounter($modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.social-character-counter.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.social-character-counter', compact('seo'));
    }

    /**
     * 5. Social Media Time Saved & ROI Calculator
     */
    public function socialRoiCalculator()
    {
        return view('tools.social-media-roi-calculator');
    }

    /**
     * 6. LinkedIn Paragraph Spacing & Line Break Formatter
     */
    public function linkedinLineBreak()
    {
        return view('tools.linkedin-line-break-generator');
    }

    /**
     * 7. GA4 UTM Link Builder & Parameter Generator
     */
    public function utmBuilder()
    {
        return view('tools.utm-link-builder');
    }

    /**
     * 8. Social Media Engagement Rate Calculator
     */
    public function engagementCalculator()
    {
        return view('tools.engagement-rate-calculator');
    }

    /**
     * 9. LinkedIn Hook Generator Template Matrix
     */
    public function linkedinHooks()
    {
        return view('tools.linkedin-hook-templates');
    }

    /**
     * 10. 30-Day Content Matrix Calendar & CSV Exporter
     */
    public function contentCalendarTemplate()
    {
        return view('tools.30-day-content-calendar-template');
    }
}
