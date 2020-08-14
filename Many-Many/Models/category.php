<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'post_id',
        'name',
        'slug',
        'description',
    ];


    /**
     * Get the post that owns the this meta.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }


    /**
     * Get total attached post with category
     *
     */
    public function getTotalPostsCount()
    {
        return $this->post()->count();
    }
}
