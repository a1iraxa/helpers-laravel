<?php

// Assign categories
$categories = [ 'Laravel', 'Helpers', 'Ali' 'Raza' ];
// $categories = $request->categories; // get from Request

// Attach one category
$post->assignCategory($category);

// Remove One Category
$post->removeCategory($categories);

// Update Categories
$post->updateCategories($categories);
