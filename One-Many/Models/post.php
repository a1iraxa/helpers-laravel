<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'dedicated_to',
    ];

    /**
     * Get the post-meta associated with the posts.
     */
    public function meta()
    {
        return $this->hasMany(PostMeta::class);
    }

    /*
     * Check if meta exists
     */
    public function hasMeta($key = '') {

        $key = trim($key);

        if( '' == $key ){
            return false;
        }

        $meta = $this->meta->filter(function ($meta) use ($key) {
            return $meta->key === $key;
        });

        if ($meta->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     *Get post meta by key or return default
     */
    public function getMeta($key = '', $defaut = '') {

        $key = trim($key);

        if( '' == $key ){
            return $defaut;
        }

        $meta = $this->meta->filter(function ($meta) use ($key) {
            return $meta->key === $key;
        });

        if ($meta->count() > 0) {
            return $meta->first()->value;
        }

        return $defaut;
    }

    /*
     *Get post meta object by key or set default
     */
    public function getMetaObject($key = '', $defaut = '') {

        $key = trim($key);

        if( '' == $key ){
            return $defaut;
        }

        $metas = $this->metas->filter(function ($metas) use ($key) {
            return $metas->key === $key;
        });

        if ($metas->count() > 0) {
            return $metas->first();
        }

        return $defaut;
    }

    /**
     * Get the post author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the dedicated tO
     */
    public function dedicated_to()
    {
        return $this->hasMany(User::class, 'dedicated_to');
    }
    /**
     * Relationship with meta count
     *
     */
    public function getTotalMeta()
    {
        return $this->meta()->count();
    }
}
