<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'slider_image_file_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'slider_image_file_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'slider_image_file_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'slider_image_file_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $page = Page::where('slug', 'home')->firstOrCreate(['slug' => 'home'], ['name' => 'Home']);
        $section = $page->sections()->firstOrCreate(['key' => 'hero'], ['content' => []]);

        $current = is_array($section->content) ? $section->content : [];

        // Build slider images array
        $sliderImages = [];
        for ($i = 1; $i <= 4; $i++) {
            $keep    = $request->input("slider_image_keep_{$i}", '0');
            $oldVal  = $current['slider_images'][$i - 1] ?? '';

            if ($request->hasFile("slider_image_file_{$i}") && $request->file("slider_image_file_{$i}")->isValid()) {
                // New file uploaded — delete old stored file if any
                if ($oldVal && str_starts_with($oldVal, '/storage/hero/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldVal));
                }
                $path = $request->file("slider_image_file_{$i}")->store('hero', 'public');
                $sliderImages[] = '/storage/' . $path;

            } elseif ($keep === '1' && $oldVal) {
                // No new file but keep existing
                $sliderImages[] = $oldVal;

            } else {
                // keep = 0 and no new file — delete old stored file
                if ($oldVal && str_starts_with($oldVal, '/storage/hero/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldVal));
                }
                // slot is empty — skip
            }
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
            'slider_images' => $sliderImages ?: ($current['slider_images'] ?? []),
        ]);

        $section->save();

        return back()->with('success', 'Hero section updated successfully.');
    }
}
