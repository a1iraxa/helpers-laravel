<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post_meta';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'post_id',
        'key',
        'value',
    ];


    /**
     * Get the post that owns the this meta.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
