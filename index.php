<?php
/**
 * The template / 'controller' for sending data to the view
 *
 * @package crafty
 */


global $wp_query;
$crafty = Crafty_Theme::get_instance();
$crafty->header();
$crafty->render( 'archive', array( 'posts' => $crafty->process_posts_array( $wp_query->posts ), 'menu' => $crafty->get_menu() ) );
$crafty->footer();
