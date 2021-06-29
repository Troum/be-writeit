<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
      'post_id',
      'image_src'
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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageSrcAttribute($value)
    {
        return strpos($value, 'http') !== false ? $value : config('app.url') . '/storage/' . $value;
    }
}
