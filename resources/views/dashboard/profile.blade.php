@extends('layouts.dashboard')

@section('title', 'Profile Settings')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 font-display">Profile Settings</h1>
            <p class="text-gray-600 mt-1">Manage your account settings and profile information.</p>
        </div>
    </div>



    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <div class="flex items-center space-x-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span class="font-semibold">Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside ml-6 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Picture Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Profile Picture</h2>

                <div class="flex flex-col items-center space-y-4">
                    <!-- Current Profile Picture -->
                    <div class="relative">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                 alt="Profile Picture"
                                 class="w-32 h-32 rounded-full object-cover border-4 border-primary shadow-lg"
                                 id="profilePreview">
                        @else
                            <div class="w-32 h-32 rounded-full bg-linear-to-r from-primary to-primary/80 flex items-center justify-center border-4 border-white shadow-lg"
                                 id="profilePreview">
                                <i class="fas fa-user text-white text-5xl"></i>
                            </div>
                        @endif

                        <!-- Camera Icon -->
                        <label for="profile_picture_input" class="absolute bottom-0 right-0 w-10 h-10 bg-primary rounded-full flex items-center justify-center cursor-pointer hover:bg-primary/80 transition-colors shadow-lg">
                            <i class="fas fa-camera text-white"></i>
                        </label>
                    </div>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">JPG, PNG or GIF</p>
                        <p class="text-xs text-gray-500">Max size: 5MB</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Information Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Hidden File Input -->
                    <input type="file"
                           id="profile_picture_input"
                           name="profile_picture"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user text-primary mr-2"></i>Full Name
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                               required>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope text-primary mr-2"></i>Email Address
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                               required>
                    </div>

                    <!-- Role Display (Read Only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-shield-alt text-primary mr-2"></i>Role
                        </label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                            Administrator
                        </div>
                    </div>

                    <!-- Account Created -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar text-primary mr-2"></i>Member Since
                        </label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-600">
                            {{ Auth::user()->created_at->format('F d, Y') }}
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button type="submit"
                                class="flex-1 px-6 py-3 bg-linear-to-r from-primary to-primary/80 text-white rounded-xl font-medium hover:shadow-lg transition-all">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('profilePreview');

    reader.onload = function() {
        if (preview.tagName === 'IMG') {
            preview.src = reader.result;
        } else {
            // Replace div with img
            const img = document.createElement('img');
            img.id = 'profilePreview';
            img.src = reader.result;
            img.className = 'w-32 h-32 rounded-full object-cover border-4 border-primary shadow-lg';
            img.alt = 'Profile Picture';
            preview.parentNode.replaceChild(img, preview);
        }
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
@endsection
