<?php
/*
 Plugin Name: uf2
 Plugin URI: https://github.com/pfefferle/wordpress-uf2
 Description: Adds microformats2 support to your WordPress theme
 Author: pfefferle
 Author URI: http://notizblog.org/
 Version: 1.0.0-dev
*/

/**
 * Adds custom classes to the array of post classes.
 */
function uf2_post_classes( $classes ) {
  // Adds a class for microformats v2
  $classes[] = 'h-entry';
  
  // adds microformats 2 activity-stream support
  // for pages and articles
  if ( get_post_type() == "page" ) {
    $classes[] = "h-as-page";
  }
  if ( !get_post_format() && get_post_type() == "post" ) {
    $classes[] = "h-as-article";
  }
  
  // adds some more microformats 2 classes based on the
  // posts "format"
  switch ( get_post_format() ) {
    case "aside":
    case "status":
      $classes[] = "h-as-note";
      break;
    case "audio":
      $classes[] = "h-as-audio";
      break;
    case "video":
      $classes[] = "h-as-video";
      break;
    case "gallery":
    case "image":
      $classes[] = "h-as-image";
      break;
    case "link":
      $classes[] = "h-as-bookmark";
      break;
  }
  
  return $classes;
}
add_filter( 'post_class', 'uf2_post_classes' );

/**
 * Adds custom classes to the array of body classes.
 */
function uf2_body_classes( $classes ) {
  if (!is_singular()) {
    $classes[] = "h-feed";
  }

  return $classes;
}
add_filter( 'body_class', 'uf2_body_classes' );

/**
 * Adds microformats v2 support to the comment_author_link.
 */
function uf2_author_link( $link ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link);
}
add_filter( 'get_comment_author_link', 'uf2_author_link' );

/**
 * Adds microformats v2 support to the get_avatar() method.
 */
function uf2_get_avatar( $tag ) {
  // Adds a class for microformats v2
  return preg_replace('/(class\s*=\s*[\"|\'])/i', '${1}u-photo ', $tag);
}
add_filter( 'get_avatar', 'uf2_get_avatar' );

/**
 * Adds microformats v2 support to the post title.
 */
function uf2_the_title( $title ) {
  return "<span class='e-name'>$title</span>";
} 
add_filter( 'the_title', 'uf2_the_title', 1, 99 );

/**
 * Adds microformats v2 support to the post.
 */
function uf2_the_post( $post ) {
  return "<div class='e-content'>$post</div>";
} 
add_filter( 'the_content', 'uf2_the_post', 1, 99 );

/**
 * Adds microformats v2 support to the excerpt.
 */
function uf2_the_excerpt( $post ) {
  return "<div class='e-content p-summary'>$post</div>";
} 
add_filter( 'the_excerpt', 'uf2_the_excerpt', 1, 99 );

/**
 * Adds microformats v2 support to the author.
 */
function uf2_the_author( $author ) {
  return "<span class='p-author h-card'>$author</span>";
} 
add_filter( 'the_author', 'uf2_the_author', 1, 99 );