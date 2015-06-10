<?php

wp_head();


$crafty = Crafty_Theme::get_instance();
$crafty->render( 'index', array( 'title' => 'From php', 'posts' => $crafty->get_posts() ) );

wp_footer();