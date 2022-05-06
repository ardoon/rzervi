<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'img' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if($request->type === 'avatar') {
            $avatars = Media::where('type', 'avatar')->where('user_id', Auth::id())->get();

            if (count($avatars) != 0) {
                foreach ($avatars as $avatar) {
                    Storage::delete($avatar->path);
                    $avatar->delete();
                }
            }
        }

        $path = $request->file('img')->store('public/images');

        Media::create([
            'name' =>  $request->name,
            'type' => $request->type,
            'path' => $path,
            'user_id' =>  Auth::id()
        ]);

        return true;
    }

    public function show(User $user, $type)
    {
        $media = Media::where('user_id', $user->id)->where('type', $type)->first();
        if ($media)
            return $media->path;

        return '';
    }

    public function destroy(User $user, $type)
    {
        $media = Media::where('user_id', $user->id)->where('type', $type)->first();
        Storage::delete($media->path);
        $media->delete();

        return back();
    }
}
