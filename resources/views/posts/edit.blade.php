<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Post
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')

                <textarea name="content" class="w-full border rounded p-2" rows="4" required>{{ old('content', $post->content) }}</textarea>

                <div class="flex justify-end mt-4 space-x-2">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
