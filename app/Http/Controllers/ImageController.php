<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function getImages()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('image.upload');
    }

    public function postImage(ImageRequest $request)
    {
        $name = $request->file('image')->getClientOriginalName();

        $path = $request->file('image')->storeAs( 'photo', $name, 'public');

        Image::create([
            'name' => $name,
            'patch' => $path,
            'user_id' => Auth::id(),
        ]);

        return view('image.upload', compact('path'));
    }
    public function getPhoto()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $imageAll = Image::all()->where('user_id', Auth::id());

        return view('image.photo', compact('imageAll'));
    }
}
