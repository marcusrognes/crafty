<?php

require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
require_once( dirname( __FILE__ ) . '/lib/crafty_theme.class.php' );

$crafty = new Crafty_Theme();

$crafty->render( 'index', array( 'title' => 'Testing', 'posts' => get_posts() ) );

