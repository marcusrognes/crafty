<?php
/**
 * The base 'model' that gets sendt to the view
 *
 * @package crafty
 */

/**
 * Class Post
 * The base 'model' that gets sendt to the view
 */
class Post {

	/**
	 * @var int
	 */
	public $ID;
	/**
	 * @var string
	 */
	public $post_title;
	/**
	 * @var string
	 */
	public $post_content;
	/**
	 * @var string
	 */
	public $post_excerpt;
	/**
	 * @var string
	 */
	public $post_author;
	/**
	 * @var string
	 */
	public $post_date;
	/**
	 * @var string
	 */
	public $post_modified;
	/**
	 * @var string
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
	 * Returns a post from a given WP_Post
	 *
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
	 * Same as get_posts but returns Post[] instead of WP_Post[]
	 *
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
