<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $post = Post::find($request->post);
            $post->comments()->create([
               'comment' => $request->comment
            ]);
            $post = $post->fresh('comments');
            return response()->json(['post' => $post],
                Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);
        }
    }
}
