<?php

namespace App\Observers;

use App\Models\Post;
use App\Traits\ImageManagerTrait;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    use ImageManagerTrait;

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;


    /**
     * Handle the Post "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param Post $post
     * @return void
     */
    public function saving(Post $post)
    {
        if (request()->has('new_file')) {
            $this->removeFolder($post->id);
            $this->storeImage(request()->new_file, $post->id);
            $post->image()->update([
                'image_src' => $this->retrieveImage($post->id)
            ]);
        }
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        $this->removeFolder($post->id);
        $post->image()->delete();
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param Post $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
