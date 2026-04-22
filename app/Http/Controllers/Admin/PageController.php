<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageSection;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('dashboard.admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        $page->load('sections');
        return view('dashboard.admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->all();
        $sections = [];

        // Group inputs by section
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'section_')) {
                // Formatting: section_{sectionKey}_{fieldName}
                $parts = explode('_', $key, 3);
                
                if (count($parts) === 3) {
                    $sectionKey = $parts[1];
                    $fieldName = $parts[2];
                    
                    // Handle 'why_choose_us' special case
                    if ($sectionKey === 'why' && str_starts_with($fieldName, 'choose_us_')) {
                        $sectionKey = 'why_choose_us';
                        $fieldName = substr($fieldName, 10);
                    }
                    // Handle 'contact_info' special case
                    elseif ($sectionKey === 'contact' && str_starts_with($fieldName, 'info_')) {
                        $sectionKey = 'contact_info';
                        $fieldName = substr($fieldName, 5);
                    }
                    // Handle 'form_area' special case
                    elseif ($sectionKey === 'form' && str_starts_with($fieldName, 'area_')) {
                        $sectionKey = 'form_area';
                        $fieldName = substr($fieldName, 5);
                    }
                    // Handle 'flash_sale' special case
                    elseif ($sectionKey === 'flash' && str_starts_with($fieldName, 'sale_')) {
                        $sectionKey = 'flash_sale';
                        $fieldName = substr($fieldName, 5);
                    }
                    // Handle 'lightning_deals' special case
                    elseif ($sectionKey === 'lightning' && str_starts_with($fieldName, 'deals_')) {
                        $sectionKey = 'lightning_deals';
                        $fieldName = substr($fieldName, 6);
                    }
                    // Handle 'top_deals' special case
                    elseif ($sectionKey === 'top' && str_starts_with($fieldName, 'deals_')) {
                        $sectionKey = 'top_deals';
                        $fieldName = substr($fieldName, 6);
                    }
                    // Handle 'category_deals' special case
                    elseif ($sectionKey === 'category' && str_starts_with($fieldName, 'deals_')) {
                        $sectionKey = 'category_deals';
                        $fieldName = substr($fieldName, 6);
                    }
                    // Handle 'featured_products' special case
                    elseif ($sectionKey === 'featured' && str_starts_with($fieldName, 'products_')) {
                        $sectionKey = 'featured_products';
                        $fieldName = substr($fieldName, 9);
                    }
                    // Handle 'company_info' special case
                    elseif ($sectionKey === 'company' && str_starts_with($fieldName, 'info_')) {
                        $sectionKey = 'company_info';
                        $fieldName = substr($fieldName, 5);
                    }
                    // Handle 'quick_links' special case
                    elseif ($sectionKey === 'quick' && str_starts_with($fieldName, 'links_')) {
                        $sectionKey = 'quick_links';
                        $fieldName = substr($fieldName, 6);
                    }
                    // Handle 'customer_service' special case
                    elseif ($sectionKey === 'customer' && str_starts_with($fieldName, 'service_')) {
                        $sectionKey = 'customer_service';
                        $fieldName = substr($fieldName, 8);
                    }
                    // Handle 'bottom_footer' special case
                    elseif ($sectionKey === 'bottom' && str_starts_with($fieldName, 'footer_')) {
                        $sectionKey = 'bottom_footer';
                        $fieldName = substr($fieldName, 7);
                    }
                    // Handle 'top_bar' special case
                    elseif ($sectionKey === 'top' && str_starts_with($fieldName, 'bar_')) {
                        $sectionKey = 'top_bar';
                        $fieldName = substr($fieldName, 4);
                    }
                    
                    // Try to decode JSON fields
                    $decodedValue = $this->decodeJsonField($value);
                    $sections[$sectionKey][$fieldName] = $decodedValue;
                }
            }
        }

        // Handle File Uploads (sections)
        foreach ($request->allFiles() as $key => $file) {
            if (str_starts_with($key, 'section_')) {
                $parts = explode('_', $key, 3);
                if (count($parts) === 3) {
                    $sectionKey = $parts[1];
                    $fieldName = $parts[2];

                    // Standardize section keys for files as well
                    if ($sectionKey === 'company' && str_starts_with($fieldName, 'info_')) {
                        $sectionKey = 'company_info';
                        $fieldName = substr($fieldName, 5);
                    }
                    elseif ($sectionKey === 'flash' && str_starts_with($fieldName, 'sale_')) {
                        $sectionKey = 'flash_sale';
                        $fieldName = substr($fieldName, 5);
                    }
                    // Handle 'top_bar' special case for files (if any)
                    elseif ($sectionKey === 'top' && str_starts_with($fieldName, 'bar_')) {
                        $sectionKey = 'top_bar';
                        $fieldName = substr($fieldName, 4);
                    }

                    if ($sectionKey === 'map' && $fieldName === 'image') {
                        $path = $file->store('pages', 'public');
                        $sections[$sectionKey][$fieldName] = $path;
                    }
                    elseif ($sectionKey === 'flash_sale' && $fieldName === 'image') {
                        $path = $file->store('pages', 'public');
                        $sections[$sectionKey][$fieldName] = $path;
                    }
                    elseif ($sectionKey === 'hero' && $fieldName === 'image') {
                        $path = $file->store('pages', 'public');
                        $sections[$sectionKey][$fieldName] = $path;
                    }
                    elseif ($sectionKey === 'company_info' && $fieldName === 'logo') {
                        $path = $file->store('pages', 'public');
                        $sections[$sectionKey][$fieldName] = $path;
                    }
                    elseif ($sectionKey === 'brand' && $fieldName === 'logo') {
                        $path = $file->store('pages', 'public');
                        $sections[$sectionKey][$fieldName] = $path;
                    }
                }
            }
        }

        // Handle policy_sections (for privacy-policy, terms-conditions, refund-policy)
        if ($request->has('policy_sections')) {
            $policySectionsData = array_values(array_filter($request->input('policy_sections', []), fn($s) => !empty($s['title'])));
            PageSection::updateOrCreate(
                ['page_id' => $page->id, 'key' => 'sections'],
                ['content' => $policySectionsData]
            );
        }

        // Save each section once
        foreach ($sections as $key => $content) {
            $section = $page->sections()->firstOrCreate(['key' => $key], ['content' => []]);
            $currentContent = is_array($section->content) ? $section->content : [];

            // Consolidate buttons (button1_text, button1_url -> buttons array)
            $buttons = [];
            foreach ($content as $fieldName => $fieldValue) {
                if (preg_match('/^button(\d+)_(text|url)$/', $fieldName, $matches)) {
                    $index = intval($matches[1]) - 1;
                    $subField = $matches[2];
                    if (!isset($buttons[$index])) {
                        // Inherit style from existing button if available, else default
                        $style = $currentContent['buttons'][$index]['style'] ?? ($index === 0 ? 'primary' : 'secondary');
                        $buttons[$index] = ['style' => $style];
                    }
                    $buttons[$index][$subField] = $fieldValue;
                    unset($content[$fieldName]);
                }
            }

            if (!empty($buttons)) {
                ksort($buttons);
                $content['buttons'] = array_values($buttons);
            }

            // Consolidate generic list items (item1_title, item1_icon -> items array)
            // This is for features, testimonials, etc.
            $items = [];
            foreach ($content as $fieldName => $fieldValue) {
                if (preg_match('/^item(\d+)_(.+)$/', $fieldName, $matches)) {
                    $index = intval($matches[1]) - 1;
                    $subField = $matches[2];
                    $items[$index][$subField] = $fieldValue;
                    unset($content[$fieldName]);
                }
            }

            if (!empty($items)) {
                ksort($items);
                // If existing content has items, we might want to preserve keys not in form, 
                // but for list items usually we replace the list or append. 
                // Here we simply use the new list from the form.
                $content['items'] = array_values($items);
            }
            
            // Consolidate slider images (slider_image_1..4 -> slider_images array)
            $sliderImages = [];
            foreach ($content as $fieldName => $fieldValue) {
                if (preg_match('/^slider_image_(\d+)$/', $fieldName, $matches)) {
                    if (!empty($fieldValue)) {
                        $sliderImages[] = $fieldValue;
                    }
                    unset($content[$fieldName]);
                }
            }
            if (!empty($sliderImages)) {
                $content['slider_images'] = $sliderImages;
            }

            // Merge with existing content to preserve fields not in current form (like background gradients)
            $newContent = array_merge($currentContent, $content);
            
            $section->content = $newContent;
            $section->save();
        }

        // Clear header/footer cache when pages are saved
        \Illuminate\Support\Facades\Cache::forget('global_header_config');
        \Illuminate\Support\Facades\Cache::forget('global_footer_config');

        return redirect()->route('admin.pages.index')->with('success', 'Page content updated successfully');
    }
    private function decodeJsonField($value)
    {
        // If it's already an array, return as is
        if (is_array($value)) {
            return $value;
        }

        // If it's a string, try to decode it
        if (is_string($value)) {
            $trimmed = trim($value);
            
            // Check if it looks like JSON (starts with [ or {)
            if (in_array($trimmed[0] ?? '', ['[', '{'])) {
                $decoded = json_decode($trimmed, true);
                
                // If decoding was successful, return the decoded value
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $decoded;
                }
            }
        }

        // Return the original value if it's not JSON
        return $value;
    }
}
