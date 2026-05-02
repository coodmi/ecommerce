<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->orderByDesc('id')->get();
        return view('dashboard.admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'message'     => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
            'avatar'      => 'nullable|image|max:2048',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        Testimonial::create($data);

        return back()->with('success', 'Testimonial added successfully.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'nullable|string|max:100',
            'message'     => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
            'avatar'      => 'nullable|image|max:2048',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'nullable|integer',
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                \Storage::disk('public')->delete($testimonial->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $testimonial->update($data);

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) {
            \Storage::disk('public')->delete($testimonial->avatar);
        }
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }
}
