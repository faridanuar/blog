<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use Illuminate\Validation\Rule;

class PostController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // register policy to auto assign method name matching because this controller uses resource method on web.php
        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        if (request()->user()->can('admin')) {
            // list all
            $posts = Post::where(['is_deleted' => 0])->filter(
                request(['search', 'category', 'author'])
            )->orderBy('created_at', 'desc')->paginate(18)->withQueryString();
        } else {
            // list authored only
            $posts = Post::where(['user_id' => request()->user()->id, 'is_deleted' => 0])->filter(
                request(['search', 'category'])
            )->orderBy('created_at', 'desc')->paginate(18)->withQueryString();
        }

        return view('dashboard.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $post = new Post;
        return view('dashboard.posts.create', ['post' => $post]);
    }

    public function store()
    {
        Post::create(array_merge($this->validatePost(), [
            'user_id' => request()->user()->id,
            'thumbnail' => request()->file('thumbnail')->store('thumbnails')
        ]));

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);

        if ($attributes['thumbnail'] ?? false) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Record Updated!');
    }

    public function destroy(Post $post)
    {
        $post->update(['is_deleted' => 1]);

        return back()->with('success', 'Record Deleted!');
    }

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        return request()->validate([
            'title' => 'required',
            'thumbnail' => $post->exists ? ['image'] : ['required', 'image'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'status_id' => 'required',
        ]);
    }
}
