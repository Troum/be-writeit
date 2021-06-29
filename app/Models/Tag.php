<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
      'post_id',
      'text'
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
}
