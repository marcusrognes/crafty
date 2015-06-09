<?php

require_once( dirname( __FILE__ ) . '/lib/crafty_theme.class.php' );

$crafty = new Crafty_Theme();

$crafty->render( 'index', array( 'title' => 'Testing', 'posts' => $crafty->get_posts() ) );

