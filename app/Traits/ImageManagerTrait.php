<?php


namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageManagerTrait
{
    /**
     * @param $file
     * @param $post_id
     * @return string
     */
    protected function storeImage($file, $post_id)
    {
        $attachment = Image::make($file)
            ->encode('jpg', 100);
        $name = "post_image_$post_id.jpg";
        Storage::put("public/posts/$post_id/" . $name, $attachment);

        return $name;
    }

    /**
     * @param $post_id
     * @return array
     */
    public function retrieveImage($post_id)
    {
        $image = Storage::disk('public')->files("posts/$post_id");
        return $image[0];
    }

    /**
     * @param $image_src
     */
    public function removeImage($image_src)
    {
        Storage::disk('public')->delete($image_src);
    }

    /**
     * @param $post_id
     */
    public function removeFolder($post_id)
    {
        Storage::disk('public')->deleteDirectory("posts/$post_id");
    }

}
