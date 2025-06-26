<x-app-layout>
   

    <div class="py-8 max-w-2xl mx-auto">
        <div class=" p-6 rounded shadow" style="background-color: #252728 !important;">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Textarea -->
                <textarea name="content" class="w-full border rounded p-2 text-white" style="background-color: #3B3D3E !important;" rows="4" required>{{ old('content', $post->content) }}</textarea>

                <!-- Existing Image -->
                @if ($post->image_path)
                    <div class="mt-4">
                        <label class="block font-semibold text-white mb-1">Current Image:</label>
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="max-w-full rounded border mb-2">
                        <input type="file" name="image" accept="image/*" class="block text-sm text-white">
                    </div>
                @else
                    <div class="mt-4">
                        <label class="block font-semibold text-white mb-1">Add Image:</label>
                        <input type="file" name="image" accept="image/*" class="block text-sm text-white">
                    </div>
                @endif

                <!-- Existing Video -->
                @if ($post->video_path)
                    <div class="mt-4">
                        <label class="block font-semibold text-white mb-1">Current Video:</label>
                        <video controls class="w-full rounded border mb-2">
                            <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <input type="file" name="video" accept="video/*" class="block text-sm text-white">
                    </div>
                @else
                    <div class="mt-4">
                        <label class="block font-semibold text-white mb-1">Add Video:</label>
                        <input type="file" name="video" accept="video/*" class="block text-sm text-white">
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex justify-end mt-6 space-x-3">
                    <a href="{{ route('home') }}" class="text-white hover:text-gray-800 py-2 px-4 bg-gray-500 rounded">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
