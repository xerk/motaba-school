<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Category;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $posts = Post::with('user', 'category')->paginate(12);
        return view('vendor.frontend.blogs.blogs', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    public function categoryIndex($slug)
    {
        $categories = Category::all();
        $slugUrl = Category::where('slug', $slug)->first();
        $posts = Post::with('user', 'category')->where('category_id', $slugUrl->id)->paginate(12);
        return view('vendor.frontend.blogs.blogs', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categorySlug, $postSlug)
    {
        $post = Post::with('user', 'category')->where('slug', $postSlug)->first();
        return view('vendor.frontend.blogs.sngile-blog', [
            'post' => $post
        ]);
    }

}
