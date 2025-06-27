
<x-app-layout>

    <div class="py-8 max-w-2xl mx-auto space-y-6">

        <!-- Create Post Box -->
        <div class=" rounded-lg shadow p-4" style="background-color: #252728 !important;">
            <div class="flex items-start space-x-3">
                <img 
    src="{{ Auth::user()->profile_photo_path 
        ? asset('storage/' . Auth::user()->profile_photo_path) 
        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" 
    class="h-10 w-10 rounded-full object-cover" 
    alt="User Avatar">
                
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="w-full space-y-2">
                    @csrf

                    <textarea name="content" style="background-color: #333334 !important;" class="w-full border rounded p-2 text-white" rows="3" placeholder="What's on your mind?" required></textarea>

                    <!-- Image & Video Upload Inputs with Icons -->
                    <div class="flex items-center justify-evenly space-x-4 text-sm text-gray-600 mt-2">
    <!-- Image Upload -->
    <label class="flex items-center cursor-pointer space-x-2">
        <i class="fa-solid fa-image text-blue-500"></i>
        <span class="hover:underline text-white">Add Photo</span>
        <input type="file" name="image" accept="image/*" onchange="previewFile(this, 'image')" class="hidden">
    </label>

    <!-- Video Upload -->
    <label class="flex items-center cursor-pointer space-x-2">
        <i class="fa-solid fa-video text-purple-500"></i>
        <span class="hover:underline text-white">Add Video</span>
        <input type="file" name="video" accept="video/*" onchange="previewFile(this, 'video')" class="hidden">
    </label>
</div>

<!-- Preview containers -->
<!-- Preview containers -->
<div id="image-preview" class="mt-2"></div>
<div id="video-preview" class="mt-2"></div>



                    <!-- Post Button -->
                    <div class="text-right">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Post
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts -->
        @forelse ($posts as $post)
        
        <div class="rounded-lg shadow p-4" style="background-color: #252728 !important;">
            <div class="flex justify-between items-center mb-2">
                <div class="flex items-center space-x-3">
                    <img
    src="{{ $post->user->profile_photo_path 
        ? asset('storage/' . $post->user->profile_photo_path) 
        : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}"
    class="h-9 w-9 rounded-full object-cover"
    alt="{{ $post->user->name }}">

                    <div>
                        <p class="font-semibold text-sm text-white">{{ $post->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @if ($post->user->id === auth()->id())
                <div class="flex space-x-2 text-sm">
                    <a href="{{ route('posts.edit', $post) }}" class="text-gray-500 hover:text-blue-700" title="edit">
    <i class="fa-solid fa-pen" title="edit"></i>
</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-500 hover:text-red-700" title="delete">
        <i class="fa-solid fa-trash" title="delete"></i>
    </button>
                    </form>
                </div>
                @endif
            </div>

            <p class="text-white text-sm mb-2">
    @if ($post->type === 'profile_update')
        <span class="font-semibold ">{{ $post->user->name }}</span> changed their profile picture.
    @else
        <span class="font-semibold hidden">{{ $post->user->name }}</span> {{ $post->content }}
    @endif
</p>

@if ($post->image_path)
    <div class="mb-3">
        <img src="{{ asset('storage/' . $post->image_path) }}"
             class="rounded-lg max-w-full h-auto border"
             alt="{{ $post->type === 'profile_update' ? 'Updated Profile Picture' : 'Post Image' }}">
    </div>
@endif

          
     

            <!-- Show Video -->
            @if ($post->video_path)
            <div class="mb-3">
                <video controls class="rounded-lg w-full h-auto border">
                    <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
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
<div class="space-y-4 text-sm mt-4">
    @foreach ($post->comments as $comment)
        <div class="flex items-start space-x-3 p-3 rounded-lg text-white" style="background: #333334 !important;">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
               <img
    src="{{ $comment->user->profile_photo_path 
        ? asset('storage/' . $comment->user->profile_photo_path) 
        : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
    alt="{{ $comment->user->name }}"
    class="w-10 h-10 rounded-full object-cover">

            </div>

            <!-- Comment Body -->
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-white leading-tight">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-200 mt-1">{{ $comment->comment }}</p>
                    </div>

                    <!-- Actions -->
                    @if ($comment->user_id === auth()->id())
                        <div class="flex items-center space-x-2 text-xs text-gray-400">
                            <a href="{{ route('comments.edit', $comment->id) }}" class="hover:text-blue-400">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="hover:text-red-400">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Timestamp -->
                <p class="text-xs text-gray-400 mt-1">
                    {{ $comment->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    @endforeach
</div>


            <!-- Add Comment -->
            <form action="{{ route('comments.store') }}" method="POST" class="mt-3 flex items-center space-x-2">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="text" name="comment" placeholder="Write a comment..." style="background-color: #3B3D3E !important;" class="w-full border text-white border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring focus:ring-blue-100" required>
                <button type="submit" class="text-white p-2 rounded text-sm" style="background-color: #333334 !important" onmouseover="this.style.backgroundColor='#4a4a4a'" onmouseout="this.style.backgroundColor='#333334'">Comment</button>
            </form>
        </div>
        @empty
        <p class="text-center text-gray-500">No posts yet. Be the first to share something!</p>
        @endforelse

    </div>

@push('scripts')
<script>
    function previewFile(input, type) {
        const file = input.files[0];
        const previewContainer = document.getElementById(type + '-preview');

        if (!file) {
            previewContainer.innerHTML = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            if (type === 'image') {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="rounded-lg max-w-full h-auto border mt-2" />`;
            } else if (type === 'video') {
                previewContainer.innerHTML = `
                    <video controls class="rounded-lg w-full h-auto border mt-2">
                        <source src="${e.target.result}" type="${file.type}">
                        Your browser does not support the video tag.
                    </video>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
</script>
@endpush





</x-app-layout>
