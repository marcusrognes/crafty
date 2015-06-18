<?php

/**
 * Class Post
 */
class Post {

	/**
	 * @var
	 */
	public $ID;
	/**
	 * @var
	 */
	public $post_title;
	/**
	 * @var
	 */
	public $post_content;
	/**
	 * @var
	 */
	public $post_excerpt;
	/**
	 * @var
	 */
	public $post_author;
	/**
	 * @var
	 */
	public $post_date;
	/**
	 * @var
	 */
	public $post_modified;
	/**
	 * @var
	 */
	public $thumbnail;

	/**
	 * @param array $args
	 */
	function __construct( $args = array() ) {
		foreach ( $args as $key => $val ) {
			$this->{$key} = $val;
		}
	}


	/**
	 * @param $post WP_Post
	 *
	 * @return self
	 */
	public static function from_wp_post( $post ) {
		$newPost = array();
		foreach ( $post as $key => $val ) {
			$newPost[ $key ] = $val;
		}
		$newPost['post_title']     = apply_filters( 'the_title', $post->post_title );
		$newPost['post_content']    = apply_filters( 'the_content', $post->post_content );
		$newPost['post_excerpt']  = apply_filters( 'the_excerpt', $post->post_excerpt );
		$newPost['post_author']  = apply_filters( 'the_author', $post->post_author );
		$newPost['post_date']   = apply_filters( 'the_date', $post->post_date );
		$newPost['post_modified']     = apply_filters( 'the_modified_date', $post->post_modified );
		$newPost['guid'] = apply_filters( 'the_permalink', $post->guid );

		return new self( $newPost );
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