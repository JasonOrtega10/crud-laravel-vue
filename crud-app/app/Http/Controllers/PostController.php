<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // llama el modelo

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        $post = Post::create($validatedData);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        //buscar el post por ID
        $post = Post::findOrFail($id);

        //actualizar el post con los nuevos datos
        $post->update($validatedData);

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //buscar el post por el id
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json($post);
    }
}
