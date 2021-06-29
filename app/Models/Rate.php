<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed post
 * @property int|mixed likes
 * @property int|mixed dislikes
 */
class Rate extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
      'post_id',
      'likes',
      'dislikes'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
      'id',
      'post_id',
      'created_at',
      'updated_at'
    ];

    /**
     * @return BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function like()
    {
        $this->likes += 1;
        $this->save();
    }

    public function dislike()
    {
        $this->dislikes += 1;
        $this->save();
    }
}
