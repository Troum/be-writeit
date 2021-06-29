<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
      'post_id',
      'comment'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
      'created_at',
      'updated_at'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'id',
        'post_id',
        'updated_at'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)
            ->diffForHumans();
    }
}
