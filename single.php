<?php
/**
 * The template / 'controller' for sending data to the view
 *
 * @package crafty
 */

global $wp_query;
$crafty = Crafty_Theme::get_instance();
$crafty->header();
$post = $crafty->process_post( current( $wp_query->posts ) );
$crafty->render( 'single', array( 'post' => $post, 'menu' => $crafty->get_menu() ) );
$crafty->footer();
