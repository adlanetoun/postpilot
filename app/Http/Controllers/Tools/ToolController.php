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
    public function linkedinPreview(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.linkedin-post-preview.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.linkedin-post-preview', compact('seo'));
    }

    /**
     * 2. Free Twitter / X Thread Splitter & Auto-Numbering
     */
    public function twitterThreadSplitter(?string $modifier = null)
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
    public function linkedinBoldItalic(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.linkedin-bold-italic-generator.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.linkedin-bold-italic-generator', compact('seo'));
    }

    /**
     * 4. Multi-Platform Social Character Limit Counter Grid
     */
    public function socialCharacterCounter(?string $modifier = null)
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
    public function socialRoiCalculator(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.social-media-roi-calculator.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.social-media-roi-calculator', compact('seo'));
    }

    /**
     * 6. LinkedIn Paragraph Spacing & Line Break Formatter
     */
    public function linkedinLineBreak(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.linkedin-line-break-generator.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.linkedin-line-break-generator', compact('seo'));
    }

    /**
     * 7. GA4 UTM Link Builder & Parameter Generator
     */
    public function utmBuilder(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.utm-link-builder.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.utm-link-builder', compact('seo'));
    }

    /**
     * 8. Social Media Engagement Rate Calculator
     */
    public function engagementCalculator(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.engagement-rate-calculator.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.engagement-rate-calculator', compact('seo'));
    }

    /**
     * 9. LinkedIn Hook Generator Template Matrix
     */
    public function linkedinHooks(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.linkedin-hook-templates.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.linkedin-hook-templates', compact('seo'));
    }

    /**
     * 10. 30-Day Content Matrix Calendar & CSV Exporter
     */
    public function contentCalendarTemplate(?string $modifier = null)
    {
        $seo = null;
        if ($modifier) {
            $seo = config("tool_modifiers.30-day-content-calendar.{$modifier}");
            if (! $seo) {
                abort(404);
            }
        }

        return view('tools.30-day-content-calendar-template', compact('seo'));
    }
}
