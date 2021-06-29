<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Post::factory(50)->create()->each(function ($post) {
            \App\Models\Tag::factory(3)->create([
               'post_id' => $post->id
            ]);
            \App\Models\Rate::factory(1)->create([
                'post_id' => $post->id
            ]);
            \App\Models\Comment::factory(1)->create([
                'post_id' => $post->id
            ]);
            \App\Models\Image::factory(1)->create([
                'post_id' => $post->id
            ]);
        });
    }
}
