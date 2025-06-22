<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        // Prevent duplicate likes
        if (! $post->likes->contains('user_id', auth()->id())) {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
        }

        return back();
    }

    public function unlike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        }

        return back();
    }
}
