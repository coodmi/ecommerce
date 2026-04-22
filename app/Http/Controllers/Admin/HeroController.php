<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function edit()
    {
        $page = Page::where('slug', 'home')->firstOrCreate(['slug' => 'home'], ['name' => 'Home']);
        $section = $page->sections()->where('key', 'hero')->first();
        $hero = $section ? $section->content : [];

        return view('dashboard.admin.hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $page = Page::where('slug', 'home')->firstOrCreate(['slug' => 'home'], ['name' => 'Home']);
        $section = $page->sections()->firstOrCreate(['key' => 'hero'], ['content' => []]);

        $current = is_array($section->content) ? $section->content : [];

        // Collect slider images (skip blanks)
        $sliderImages = [];
        for ($i = 1; $i <= 4; $i++) {
            $val = trim($request->input("slider_image_{$i}", ''));
            if ($val) $sliderImages[] = $val;
        }

        $section->content = array_merge($current, [
            'badge_text'            => $request->input('badge_text', ''),
            'title_prefix'          => $request->input('title_prefix', ''),
            'title_suffix'          => $request->input('title_suffix', ''),
            'description'           => $request->input('description', ''),
            'stats_happy_customers' => $request->input('stats_happy_customers', '50K+'),
            'stats_products'        => $request->input('stats_products', '1000+'),
            'stats_rating'          => $request->input('stats_rating', '4.9★'),
            'buttons' => [
                ['text' => $request->input('button1_text', 'Shop Now'),  'url' => $request->input('button1_url', '/shop'),  'style' => 'primary'],
                ['text' => $request->input('button2_text', 'View Deals'),'url' => $request->input('button2_url', '/deals'), 'style' => 'secondary'],
            ],
            'slider_images' => $sliderImages ?: $current['slider_images'] ?? [],
        ]);

        $section->save();

        return back()->with('success', 'Hero section updated successfully.');
    }
}
