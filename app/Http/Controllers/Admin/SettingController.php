<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $primaryColor   = Setting::get('primary_color', '#9333ea');
        $secondaryColor = Setting::get('secondary_color', '#FFDF20');

        $deliveryCharge        = Setting::get('delivery_charge', '0');
        $deliveryFreeThreshold = Setting::get('delivery_free_threshold', '0');
        $deliveryLabel         = Setting::get('delivery_label', 'Delivery Charge');

        $whatsappNumber = Setting::get('whatsapp_number', '');
        $callNumber     = Setting::get('call_number', '');

        $siteName  = Setting::get('site_name', config('app.name'));
        $siteTitle = Setting::get('site_title', 'Your Premium Shopping Destination');
        $favicon   = Setting::get('favicon', '');

        return view('dashboard.admin.settings.index', compact(
            'primaryColor', 'secondaryColor',
            'deliveryCharge', 'deliveryFreeThreshold', 'deliveryLabel',
            'whatsappNumber', 'callNumber',
            'siteName', 'siteTitle', 'favicon'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'primary_color'             => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color'           => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'delivery_charge'           => ['nullable', 'numeric', 'min:0'],
            'delivery_free_threshold'   => ['nullable', 'numeric', 'min:0'],
            'delivery_label'            => ['nullable', 'string', 'max:50'],
            'whatsapp_number'           => ['nullable', 'string', 'max:20'],
            'call_number'               => ['nullable', 'string', 'max:20'],
            'site_name'                 => ['nullable', 'string', 'max:100'],
            'site_title'                => ['nullable', 'string', 'max:200'],
            'favicon'                   => ['nullable', 'image', 'mimes:png,jpg,jpeg,ico,svg,webp', 'max:512'],
        ]);

        Setting::set('primary_color',           $request->primary_color);
        Setting::set('secondary_color',         $request->secondary_color);
        Setting::set('delivery_charge',         $request->input('delivery_charge', 0));
        Setting::set('delivery_free_threshold', $request->input('delivery_free_threshold', 0));
        Setting::set('delivery_label',          $request->input('delivery_label', 'Delivery Charge'));
        Setting::set('whatsapp_number',         $request->input('whatsapp_number', ''));
        Setting::set('call_number',             $request->input('call_number', ''));
        Setting::set('site_name',               $request->input('site_name', config('app.name')));
        Setting::set('site_title',              $request->input('site_title', ''));

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon
            $oldFavicon = Setting::get('favicon', '');
            if ($oldFavicon && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldFavicon)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldFavicon);
            }
            $path = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $path);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
