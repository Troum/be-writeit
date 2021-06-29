<?php

namespace App\Models;

use App\Traits\ImageManagerTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed id
 * @property mixed post_content
 * @property mixed title
 * @property mixed image
 * @property mixed author
 * @method static paginate(int $int)
 * @method static find(mixed $post_id)
 */
class Post extends Model
{
    use HasFactory, ImageManagerTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
      'title',
      'post_content',
      'author'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:j F Y',
        'updated_at' => 'datetime:j F Y',
    ];

    /**
     * @var string[]
     */
    protected $with = [
      'image',
      'tags',
      'comments',
      'rating'
    ];

    /**
     * @param $data
     */
    public function store($data)
    {
        $this->title = $data->title;
        $this->post_content = $data->post_content;
        $this->author = auth()->user()->name;
        $this->save();
        $this->storeImage($data->image, $this->id);

        $this->image()->create([
            'image_src' => $this->retrieveImage($this->id)
        ]);

        $this->rating()->create([
            'likes' => 0,
            'dislikes' => 0
        ]);

        foreach ($data->tags as $tag) {
            $this->tags()->create([
                'text' => $tag['text']
            ]);
        }
    }

    /**
     * @return HasOne
     */
    public function image()
    {
        return $this->hasOne(Image::class, 'post_id');
    }

    /**
     * @return HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class, 'post_id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * @return HasOne
     */
    public function rating()
    {
        return $this->hasOne(Rate::class, 'post_id');
    }
}
