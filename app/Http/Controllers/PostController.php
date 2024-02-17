<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Post;
use App\Models\User;
use App\Models\UserPostLike;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function getFormCreatPost(): View
    {
        return view('creatPost');
    }

    public function creatPost(Request $request)
    {
        Post::create([
            'user_id' => Auth::id(),
            'content' => $request['content'],
        ]);
        return redirect()->route('creatPost');
    }


    public function getPosts()
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }


        $friends = User::find(Auth::id())->friends;
        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }

        $friendPosts = Post::all()->whereIn('user_id', $arrFriendId);

        $users = User::all();
        $user = Auth::user();

        $likes = UserPostLike::all()->where('user_id', Auth::id());

        foreach ($likes as $lik) {
            $like[$lik['post_id']] = $lik['post_id'];
        }

        if (empty($like)) {
            return view('post', compact('friendPosts', 'users', 'user'));
        }
        return view('post', compact('friendPosts', 'users', 'user', 'like'));

    }

    public function likePosts(Request $request)
    {
//        $like = User::find(Auth::id())->posts()->toggle($request->post_id);
        $postId= $request->post_id;
        $user = Auth::user();
        if($user->posts->contains($postId)) {
            $like = UserPostLike::where('post_id', $postId)->where('user_id', Auth::id());
            $like->delete();

        } else {
            UserPostLike::create([
                'user_id' => Auth::id(),
                'post_id' => $request->post_id,
            ]);
        }
        $friends = User::find(Auth::id())->friends;
        foreach ($friends as $key => $elem) {
            $arrFriendId[] = $elem['friend_id'];
        }

        $friendPosts = Post::all()->whereIn('user_id', $arrFriendId);

        $users = User::all();

        $likes = UserPostLike::all()->where('user_id', Auth::id());

        foreach ($likes as $lik) {
            $like[$lik['post_id']] = $lik['post_id'];
        }
        if (empty($like)) {
            return view('post', compact('friendPosts', 'users', 'user'));
        }

        return view('post', compact('friendPosts', 'users', 'user', 'like'));
    }

    public function deletePost(Request $request)
    {
        if (isset($_POST['update'])) {
            return $this->deletePost($request);
        }
        $post = Post::find($request->delete);

        $post->delete();

        return redirect()->route('main');
    }
    public function updatePost(Request $request)
    {
        if (isset($_POST['delete'])) {
            return $this->deletePost($request);
        }
        $post = Post::find($request->update);

        $post->update([
            'content' => $request->content,
        ]);
        return redirect()->route('main');
    }
}
