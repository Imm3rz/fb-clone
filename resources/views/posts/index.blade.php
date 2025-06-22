<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            News Feed
        </h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto space-y-6">

        <!-- Create Post Box -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-start space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="h-10 w-10 rounded-full" alt="User Avatar">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <textarea name="content" class="w-full border rounded p-2" rows="3" placeholder="What's on your mind?" required></textarea>

                    <div class="mt-2">
                        <input type="file" name="image" accept="image/*" class="text-sm text-gray-600">
                    </div>

                    <div class="text-right mt-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Post</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts -->
        @forelse ($posts as $post)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}" class="h-9 w-9 rounded-full" alt="User Avatar">
                    <div>
                        <p class="font-semibold text-sm">{{ $post->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if ($post->user->id === auth()->id())
                <div class="flex space-x-2 text-sm">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </div>
                @endif
            </div>

            <p class="text-gray-800 text-sm mb-2">{{ $post->content }}</p>

            @if ($post->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" class="rounded-lg max-w-full h-auto border">
                </div>
            @endif

            <!-- Like/Unlike -->
            <div class="mb-2 text-sm">
                @if ($post->likes->contains('user_id', auth()->id()))
                    <form action="{{ route('posts.unlike', $post) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:underline">Unlike ({{ $post->likes->count() }})</button>
                    </form>
                @else
                    <form action="{{ route('posts.like', $post) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:underline">Like ({{ $post->likes->count() }})</button>
                    </form>
                @endif
            </div>

            <!-- Comments -->
            <div class="space-y-2 text-sm">
                @foreach ($post->comments as $comment)
                <div class="border-t pt-2">
                    <span class="font-medium">{{ $comment->user->name }}:</span>
                    <span>{{ $comment->comment }}</span>
                    <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>

            <!-- Add Comment -->
            <form action="{{ route('comments.store') }}" method="POST" class="mt-3 flex items-center space-x-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="text" name="comment" placeholder="Write a comment..." class="w-full border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring focus:ring-blue-100" required>
                <button type="submit" class="text-blue-600 text-sm hover:underline">Comment</button>
            </form>
        </div>
        @empty
        <p class="text-center text-gray-500">No posts yet. Be the first to share something!</p>
        @endforelse

    </div>
</x-app-layout>
