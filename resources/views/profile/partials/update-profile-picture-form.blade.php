<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Photo</h2>
        <p class="mt-1 text-sm text-gray-600">Upload or change your profile picture.</p>
    </header>

    <form method="POST" action="{{ route('profile.upload-photo') }}" enctype="multipart/form-data" class="mt-4 space-y-4">
        @csrf
        @method('PATCH')

        <!-- File input -->
        <div>
            <input type="file" name="profile_photo" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            @error('profile_photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- New Caption input -->
        <div>
            <label for="caption" class="block text-sm font-medium text-gray-700">Caption (optional)</label>
            <input type="text" name="caption" id="caption" placeholder="Write a caption..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" />
        </div>

        <!-- Submit button and preview -->
        <div class="flex items-center gap-4">
            <x-primary-button>Upload</x-primary-button>

            @if (auth()->user()->profile_photo_path)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile Photo" class="h-12 w-12 rounded-full object-cover">
            @endif
        </div>
    </form>
</section>
