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
        'image' => 'nullable|image|max:2048', // Accepts images only up to 2MB
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
    }

    Post::create([
        'user_id' => auth()->id(),
        'content' => $request->content,
        'image_path' => $imagePath,
    ]);

    return back();
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
        ]);

        $post->update([
            'content' => $request->content,
        ]);

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
