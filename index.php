<?php
global $wp_query;
$crafty = Crafty_Theme::get_instance();
$crafty->header();
$crafty->render( 'archive', array( 'posts' => $crafty->process_posts_array( $wp_query->posts ) ) );
$crafty->footer();