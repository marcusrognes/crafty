<?php

/**
 * Class Post
 */
class Post {

	public $ID;
	public $post_title;
	public $post_content;
	public $post_excerpt;
	public $post_author;
	public $post_date;
	public $post_modified;
	public $thumbnail;

	/**
	 * @param array $args
	 */
	function __construct( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'ID'            => '',
			'post_title'    => '',
			'post_content'  => '',
			'post_excerpt'  => '',
			'post_author'   => '',
			'post_date'     => '',
			'post_modified' => '',
			'thumbnail'     => '',
		) );

		$this->ID            = $args['ID'];
		$this->post_title    = $args['post_title'];
		$this->post_content  = $args['post_content'];
		$this->post_excerpt  = $args['post_excerpt'];
		$this->post_author   = $args['post_author'];
		$this->post_date     = $args['post_date'];
		$this->post_modified = $args['post_modified'];
		$this->thumbnail     = $args['thumbnail'];
	}


	/**
	 * @param $post WP_Post
	 *
	 * @return self
	 */
	public static function from_wp_post( $post ) {
		return new self( array(
			'ID'            => $post->ID,
			'post_title'    => apply_filters( 'the_title', $post->post_title ),
			'post_content'  => apply_filters( 'the_content', $post->post_content ),
			'post_excerpt'  => apply_filters( 'the_excerpt', $post->post_excerpt ),
			'post_author'   => apply_filters( 'the_author', $post->post_author ),
			'post_date'     => apply_filters( 'the_date', $post->post_date ),
			'post_modified' => apply_filters( 'the_modified_date', $post->post_modified ),
			'guid'          => apply_filters( 'the_permalink', $post->guid ),
//			'thumbnail' => apply_filters( '', $post-> ),
		) );
	}

	/**
	 * TODO: Make this revert from_wp_post
	 */
	public function to_wp_post() {

	}

	/**
	 * @param array $args
	 *
	 * @return self[]
	 */
	public static function query( $args = array() ) {
		$wp_posts = get_posts( $args );
		$posts    = array();
		foreach ( $wp_posts as $wp_post ) {
			array_push( $posts, self::from_wp_post( $wp_post ) );
		}

		return $posts;
	}

}