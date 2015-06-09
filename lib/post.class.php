<?php

/**
 * Class Post
 */
class Post {

	public $id;
	public $title;
	public $content;
	public $excerpt;
	public $author;
	public $published;
	public $updated;
	public $thumbnail;

	/**
	 * @param array $args
	 */
	function __construct( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'id'        => '',
			'title'     => '',
			'content'   => '',
			'excerpt'   => '',
			'author'    => '',
			'published' => '',
			'updated'   => '',
			'thumbnail' => '',
		) );

		$this->id        = $args['id'];
		$this->title     = $args['title'];
		$this->content   = $args['content'];
		$this->excerpt   = $args['excerpt'];
		$this->author    = $args['author'];
		$this->published = $args['published'];
		$this->updated   = $args['updated'];
		$this->thumbnail = $args['thumbnail'];
	}


	/**
	 * @param $post WP_Post
	 *
	 * @return self
	 */
	public static function from_wp_post( $post ) {
		return new self( array(
			'id'        => $post->ID,
			'title'     => apply_filters( 'the_title', $post->post_title ),
			'content'   => apply_filters( 'the_content', $post->post_content ),
			'excerpt'   => apply_filters( 'the_excerpt', $post->post_excerpt ),
			'author'    => apply_filters( 'the_author', $post->post_author ),
			'published' => apply_filters( 'the_date', $post->post_date ),
			'modified'  => apply_filters( 'the_modified_date', $post->post_modified ),
			'link'      => apply_filters( 'the_permalink', $post->guid ),
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