<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $primaryColor = Setting::get('primary_color', '#9333ea');
        $secondaryColor = Setting::get('secondary_color', '#FFDF20');
        return view('dashboard.admin.settings.index', compact('primaryColor', 'secondaryColor'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'primary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'secondary_color' => ['required', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        Setting::set('primary_color', $request->primary_color);
        Setting::set('secondary_color', $request->secondary_color);

        return back()->with('success', 'Site settings updated successfully!');
    }
}
