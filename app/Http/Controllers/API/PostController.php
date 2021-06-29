<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Traits\ImageManagerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            if (auth()->check()) {
                $posts = Post::where('author', '=', auth()->user()->name)
                    ->get();
                return response()->json(['posts' => $posts], Response::HTTP_OK);
            }
            return response()->json(['posts' => Post::paginate(4)], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request)
    {
        try {
            $post = new Post();
            $post->store($request);

            return response()->json(['success' => 'Post was successfully added'],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post)
    {
        try {
            return response()->json(['post' => $post], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        try {
            $post->title = $request->title;
            $post->post_content = $request->post_content;
            $post->save();
            return response()->json(['success' => 'Post was successfully updated'],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return response()->json(['success' => 'Post was successfully deleted'],Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
