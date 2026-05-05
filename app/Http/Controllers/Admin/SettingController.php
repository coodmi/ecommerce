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

        return view('dashboard.admin.settings.index', compact(
            'primaryColor', 'secondaryColor',
            'deliveryCharge', 'deliveryFreeThreshold', 'deliveryLabel',
            'whatsappNumber', 'callNumber'
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
        ]);

        Setting::set('primary_color',           $request->primary_color);
        Setting::set('secondary_color',         $request->secondary_color);
        Setting::set('delivery_charge',         $request->input('delivery_charge', 0));
        Setting::set('delivery_free_threshold', $request->input('delivery_free_threshold', 0));
        Setting::set('delivery_label',          $request->input('delivery_label', 'Delivery Charge'));
        Setting::set('whatsapp_number',         $request->input('whatsapp_number', ''));
        Setting::set('call_number',             $request->input('call_number', ''));

        return back()->with('success', 'Settings updated successfully!');
    }
}
