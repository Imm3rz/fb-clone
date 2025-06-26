<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show all posts.
     */
    public function index()
    {
        $posts = Post::with(['user', 'comments.user', 'likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Store a new post.
     */
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:20480',
    ]);

if (!$request->content && !$request->file('image') && !$request->file('video')) {
    return redirect()->back()->withErrors(['content' => 'Please write something or upload a file.']);
}

    $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;
    $videoPath = $request->file('video') ? $request->file('video')->store('videos', 'public') : null;

    Post::create([
        'user_id' => auth()->id(),
        'content' => $request->content,
        'image_path' => $imagePath,
        'video_path' => $videoPath,
    ]);

    return redirect()->back();
}



    /**
     * Show edit form.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // optional: if using policies

        return view('posts.edit', compact('post'));
    }

    /**
     * Update a post.
     */
    public function update(Request $request, Post $post)
{
    $this->authorize('update', $post); // optional

    $request->validate([
        'content' => 'required|string|max:1000',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video' => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:20480',
    ]);

    // Handle image upload if a new one is selected
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $post->image_path = $imagePath;
    }

    // Handle video upload if a new one is selected
    if ($request->hasFile('video')) {
        $videoPath = $request->file('video')->store('videos', 'public');
        $post->video_path = $videoPath;
    }

    // Always update the content
    $post->content = $request->content;
    $post->save();

    return redirect()->route('home');
}


    /**
     * Delete a post.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // optional

        $post->delete();

        return redirect()->back();
    }
}
