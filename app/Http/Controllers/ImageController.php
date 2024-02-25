<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function getFormImages(): View
    {
        return view('image');
    }

    public function postImage(Request $request)
    {

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);


        $name = $request->file('image')->getClientOriginalName();


        $path = $request->file('image')->store('public/photo');

        Image::create([
            'name' => $name,
            'patch' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect('image')->withSuccess('The image has been uploaded successfully');

    }
    public function getPhoto()
    {
//        $image = Image::where('user_id', Auth::id())->find(7);
        $imageAll = Image::all()->where('user_id', Auth::id());

        return view('photo', compact('imageAll'));
    }
}