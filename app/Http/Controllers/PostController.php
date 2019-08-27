<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(5);

        return response()->json(['posts' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'min:2'],
            'description' => ['required', 'string', 'min:2']
        ]);

        Post::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => auth()->user()->id
        ]);

        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  str  $postId
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $post = Post::findOrFail($postId);

        abort_unless(Gate::allows('owns-post', $post), 403);

        return response()->json(['post' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  str  $postId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);

        abort_unless(Gate::allows('owns-post', $post), 403);

        $validatedData = $request->validate([
            'title' => ['required', 'string', 'min:2'],
            'description' => ['required', 'string', 'min:2']
        ]);

        $post->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description']
        ]);

        return response()->json([], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  str  $postId
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);

        abort_unless(Gate::allows('owns-post', $post), 403);

        $post->delete();

        return response()->json([], 200);
    }
}
