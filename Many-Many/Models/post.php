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
     * Get the post-categories associated with this post.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function assignCategory($category)
    {
        return $this->categories()->attach($category);
    }

    public function removeCategory($category)
    {
        return $this->categories()->detach($category);
    }

    public function updateCategories($categories)
    {
        return $this->categories()->sync($categories);
    }

    /*
     *Get post categories comma separated
     */
    public function getCategories() {

        if ( $this->categories->count() > 0) {

            $data = '';
            foreach ( $this->categories as $key => $category) {
                $data .= $category['name']. ', ';
            }

            return rtrim($data,',');
        }
    }

    /**
     * Get total attached categories
     *
     */
    public function getTotalCategoriesCount()
    {
        return $this->categories()->count();
    }
}
