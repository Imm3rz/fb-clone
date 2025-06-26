<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        return back();
    }

    // ✏️ Show edit comment form
    public function edit(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    // 🔁 Update comment
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->route('home');
    }

    // 🗑 Delete comment
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back();
    }
}
