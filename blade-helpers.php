<?php
// 1. Check if the user is authenticated

@if(auth()->user())
    // The user is authenticated.
@endif

@auth
    // The user is authenticated.
@endauth

// 2. Check if the user is a guest
@if(auth()->guest())
    // The user is not authenticated.
@endif
@guest
    // The user is not authenticated.
@endguest
// We can also combine those two directives using the else statement:

@guest
    // The user is not authenticated.
@else
    // The user is authenticated.
@endguest

// 3. Include the first view if it exists or includes the second if it doesn’t

@if(view()->exists('first-view-name'))
    @include('first-view-name')
@else
    @include('second-view-name')
@endif

@includeFirst(['first-view-name', 'second-view-name']);


// 4. Include a view based on a condition
@if($post->hasComments())
    @include('posts.comments')
@endif
@includeWhen($post->hasComments(), 'posts.comments');

// 5. Include a view if it exists

@if(view()->exists('view-name'))
    @include('view-name')
@endif

@includeIf('view-name')
