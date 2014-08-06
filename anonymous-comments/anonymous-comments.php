<?php
/*
Plugin Name: Anonymous Comments
Plugin URI: 
Description: Adds a "Post anonymously" checkbox to the comments form. This works
             by unlinking the comment from the any users before saving to the 
             database
Version: 1.0.0
Author: James McFall
Author URI: http://mcfall.geek.nz
*/

add_action('comment_form_defaults', 'addAnonCheckbox');
add_filter('preprocess_comment', 'makeCommentAnonymous');

/**
 * Adds a "Post anonymously" checkbox into the comment form after the comment field.
 * 
 * @param <array> $default
 * @return <array>
 */
function addAnonCheckbox($default) {
    
    $checkbox = '<input name="postAnonymously" id="postAnonymously" type="checkbox" />'
    . '<label for="postAnonymously" class="postAnonymously">Post Anonymously</label>';
    
    # Stick the new field on after the comment field
    $default['comment_field'] .= $checkbox;
    
    return $default;
    
}

/**
 * This function runs before the comment data ($commentArray) is inserted into
 * the database. 
 * 
 * Unfortunatly updating the comment author in the array does nothing (it 
 * immediatly gets overwritten by Wordpress again) which left me with no option
 * other than unsetting the user ID so that Wordpress can't re-update the author
 * details.
 * 
 * @param <array> $commentArray
 * @return <array>
 */
function makeCommentAnonymous($commentArray) {
    
    # If the checkbox has been ticked, post anonymously.
    $postAnonymously = isset($_POST["postAnonymously"]) ? true : false;
    
    if ($postAnonymously) {
        
        # Setting the author here just gets overwritten, but doing it anyway.
        $commentArray["comment_author"] = "Anonymous";
        $commentArray["comment_author_email"] = "Anonymous";
        
        # Kill the user id so Wordpress can't re-populate the names
        $commentArray["user_ID"] = $commentArray["user_id"] = 0;
        
        
        # Setting the author here just gets overwritten, but doing it anyway.
        $commentArray["comment_as_submitted"]["comment_author"] = "Anonymous";
        $commentArray["comment_as_submitted"]["comment_author_email"] = "Anonymous";
        
        # Kill the user id so Wordpress can't re-populate the names
        $commentArray["comment_as_submitted"]["user_ID"] = 0;
        
    }

    return $commentArray;
}
