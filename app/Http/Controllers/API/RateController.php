<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RateController extends Controller
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
            $type = $request->type;
            switch ($type) {
                case 'like':
                    $post->rating->like();
                    break;
                case 'dislike':
                    $post->rating->dislike();
                    break;
            }
            return response()->json(['post' => $post],
                Response::HTTP_OK);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],
                Response::HTTP_BAD_REQUEST);
        }
    }
}
