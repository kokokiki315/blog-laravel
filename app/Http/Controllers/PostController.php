<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Post;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->take(50)
            ->get();

        return view('home', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        $validated['user_id'] = auth()->id();

        // Automatically set title as first 20 chars of message
        $validated['title'] = substr($validated['message'], 0, 20);

        // Optional slug for route binding
        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title'] . '-' . \Illuminate\Support\Str::random(6));

        \App\Models\Post::create($validated);

        return redirect()->back()->with('success', 'Your post has been posted!');
    }



    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        $post->update($validated);

        return redirect('/')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect('/')->with('success', 'Post deleted!');
    }
}
