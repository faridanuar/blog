<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Utilities\Concrete\Admin;
use App\Utilities\Concrete\Employer;
use App\Utilities\Singleton\TodaysQuote;

class PostController extends Controller
{
    public function index()
    {   
        //$this->runTest();

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

    protected function runTest()
    {
        $array = [
            new Admin('John', 28),
            new Employer('Mary', 25),
            new Admin('Steve', 30),
        ];

        foreach ($array as $person) {
            echo "{$person->role()}, {$person->introduce()}, {$person->age()} <br>";
        }

        exit;
    }
}
