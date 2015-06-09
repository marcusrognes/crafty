<?php

/**
 * Class Crafty_Theme
 */
class Crafty_Theme {
	/**
	 * @var self
	 */
	private static $instance;


	/**
	 * @var Mustache_Engine
	 */
	private $mustache;

	/**
	 *
	 */
	function __construct() {
		self::$instance = $this;
		$this->load_dependencies();
		$this->add_actions();
		$this->add_actions();
	}

	/**
	 * @param array $args
	 *
	 * @return array
	 */
	public function get_posts( $args = array() ) {
		return Post::query( $args );
	}

	/**
	 *
	 */
	public function load_dependencies() {
		require_once( realpath( dirname( __FILE__ ) . '/../' ) . '/vendor/autoload.php' );
		require_once( realpath( dirname( __FILE__ ) . '/../' ) . '/lib/post.class.php' );

		$this->mustache = new Mustache_Engine( array(
			'loader' => new Mustache_Loader_FilesystemLoader( realpath( dirname( __FILE__ ) . '/../' ) . '/views', array( 'extension' => '.html' ) )
		) );
	}


	/**
	 * @param string $template
	 * @param array $args
	 */
	public function render( $template = '', $args = array() ) {
		echo $this->mustache->render( $template, $args );
	}

	/**
	 *
	 */
	public function setup_templating() {

	}

	/**
	 *
	 */
	public function add_actions() {

	}

	/**
	 *
	 */
	public function add_filters() {

	}


	/**
	 * @return Crafty_Theme
	 */
	public static function get_instance() {
		if ( isset( self::$instance ) ) {
			return self::$instance;
		}

		self::$instance = new self();

		return self::$instance;
	}
}
