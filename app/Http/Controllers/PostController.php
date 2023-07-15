<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->where(['status_id' => Post::STATUS_PUBLISHED, 'is_deleted' => 0])->filter(
                request(['search', 'category', 'author'])
            )->paginate(18)->withQueryString()
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status_id != Post::STATUS_PUBLISHED) {
            \abort(404);
        }

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
