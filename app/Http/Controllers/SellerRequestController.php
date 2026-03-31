<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerRequest;
use Illuminate\Support\Facades\Auth;

class SellerRequestController extends Controller
{
    // User submits seller request
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone_number' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'business_address' => 'required|string|max:500',
            'business_phone_number' => 'required|string|max:20',
            'business_description' => 'required|string|max:1000',
            'message' => 'nullable|string|max:500',
        ]);

        // Check if user already has pending request
        $existingRequest = SellerRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already have a pending seller request.');
        }

        // Check if user is already a seller
        if (Auth::user()->isSeller()) {
            return back()->with('error', 'You are already a seller.');
        }

        SellerRequest::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'business_name' => $request->business_name,
            'business_address' => $request->business_address,
            'business_phone_number' => $request->business_phone_number,
            'business_description' => $request->business_description,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your seller request has been submitted successfully!');
    }

    // Admin views all requests
    public function index()
    {
        $requests = SellerRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.admin.seller-requests', compact('requests'));
    }

    // Admin views a single request details
    public function show($id)
    {
        $request = SellerRequest::with('user')->findOrFail($id);
        return view('dashboard.admin.seller-request-details', compact('request'));
    }

    // Admin approves request
    public function approve($id)
    {
        $request = SellerRequest::findOrFail($id);

        $request->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        // Update user role to seller
        $request->user->update(['role' => 'seller']);

        return back()->with('success', 'Seller request approved successfully!');
    }

    // Admin rejects request
    public function reject($id)
    {
        $request = SellerRequest::findOrFail($id);

        $request->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Seller request rejected.');
    }
    // Admin deletes request
    public function destroy($id)
    {
        $request = SellerRequest::findOrFail($id);
        $request->delete();

        return back()->with('success', 'Seller request deleted successfully!');
    }
}
