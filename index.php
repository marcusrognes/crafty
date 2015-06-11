<?php

wp_head();

global $wp_query;
$crafty = Crafty_Theme::get_instance();
$crafty->render( 'index', array( 'title' => 'From php', 'posts' => $crafty->process_posts_array( $wp_query->posts ) ) );

wp_footer();