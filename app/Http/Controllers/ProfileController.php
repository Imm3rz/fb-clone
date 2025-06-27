<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Show the user's profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's name and email.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Upload and update the user's profile photo,
     * and create a "changed profile picture" post.
     */
 public function uploadPhoto(Request $request): RedirectResponse
{
    $request->validate([
        'profile_photo' => ['required', 'image', 'max:2048'],
        'caption' => ['nullable', 'string', 'max:255'],
    ]);

    $user = $request->user();

    // Delete old photo file
    if ($user->profile_photo_path) {
        Storage::disk('public')->delete($user->profile_photo_path);
    }

    // Upload new file
    $path = $request->file('profile_photo')->store('profile-photos', 'public');

    // Save to user
    $user->profile_photo_path = $path;
    $user->save();

    // Delete old profile update posts
    Post::where('user_id', $user->id)
        ->where('type', 'profile_update')
        ->delete();

    // Build caption post content
    $caption = $request->input('caption');
    $content = '';
    if ($caption) {
        $content .= ' ' . $caption;
    }

    // Save new post
    Post::create([
        'user_id' => $user->id,
        'content' => $content,
        'image_path' => $path,
        'type' => 'profile_update',
    ]);

    return redirect()->route('profile.edit')->with('status', 'profile-photo-updated');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
