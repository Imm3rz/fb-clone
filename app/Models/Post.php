<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    'content',
    'user_id',
    'image_path',
    'video_path', 
    'type',
];

public function user() {
    return $this->belongsTo(User::class);
}
public function comments() {
    return $this->hasMany(Comment::class);
}
public function likes() {
    return $this->hasMany(Like::class);
}
public function sharedPost()
{
    return $this->belongsTo(Post::class, 'shared_post_id')->with('user');
}



}
