<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::published();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->ordered()->paginate(9);

        return view('frontend.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
                        ->where('is_published', true)
                        ->where('published_at', '<=', now())
                        ->firstOrFail();

        // Get related posts (latest 3 excluding current)
        $relatedPosts = BlogPost::published()
                                ->where('id', '!=', $post->id)
                                ->take(3)
                                ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }
}
