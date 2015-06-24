<?php
/**
 * The template / 'controller' for sending data to the view
 *
 * @package crafty
 */

global $wp_query;
$crafty = Crafty_Theme::get_instance();
$crafty->header();
$posts = $crafty->process_posts_array( $wp_query->posts );
$crafty->render( 'archive', array( 'slider' => $posts, 'posts' => $posts, 'menu' => $crafty->get_menu() ) );
$crafty->footer();
