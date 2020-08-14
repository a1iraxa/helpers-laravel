<?php

// Add or update meta
function update_postmeta($key='', $value, $post_obj)
{
    $value = trim($value);

    if( '' == $value ){
        return false;
    }

    if( ! is_object($post_obj) ){
        return false;
    }

    $post = $post_obj;

    PostMeta::where('post_id', '=', $post->id )->where('key', '=', $key )->delete();

    $post_meta = new PostMeta([
        'key' => $key,
        'value' => ( '' != $value ) ? $value : '',
    ]);

    $post_meta->post()->associate($post);

    $post_meta->save();
}
