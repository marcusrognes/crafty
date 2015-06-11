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

	private $version;

	/**
	 *
	 */
	function __construct() {
		self::$instance = $this;
		$this->version  = '0.0.1';
		$this->load_dependencies();


		$this->add_actions();
		$this->add_filters();
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
	public function setup_js() {
		$views = array(
			'post/list'         => realpath( dirname( __FILE__ ) . '/../' ) . '/views/post/list.html',
			'index'             => realpath( dirname( __FILE__ ) . '/../' ) . '/views/index.html',
			'header/mobile.nav' => realpath( dirname( __FILE__ ) . '/../' ) . '/views/header/mobile.nav.html',
			'style/background'  => realpath( dirname( __FILE__ ) . '/../' ) . '/views/style/background.html',
		);

		echo $this->get_js_ready_views( $views );
	}

	/**
	 *
	 */
	public function add_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'setup_js' ) );
	}


	/**
	 *
	 */
	public function add_filters() {

	}

	/**
	 *
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'crafty-blocking', get_template_directory_uri() . '/static/js/blocking.js', array( 'jquery' ), $this->version );
		wp_enqueue_style( 'crafty-blocking', get_template_directory_uri() . '/static/css/blocking.css', null, $this->version );
		wp_localize_script( 'crafty-blocking', 'craftyBlocking', array(
			'themeUri' => get_template_directory_uri()
		) );
	}

	/**
	 * @param array $views
	 *
	 * @return string
	 */
	public function get_js_ready_views( $views ) {
		$data = '';
		foreach ( $views as $name => $path ) {
			$view = $this->get_raw_view( $path );
			if ( ! $view ) {
				continue;
			}
			$data .= '<script data-name="' . $name . '" class="mustache-view" type="x-tmpl-mustache">';
			$data .= $view;
			$data .= '</script>';
		}

		return $data;
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function get_raw_view( $path = '' ) {
		if ( ! file_exists( $path ) ) {
			return '';
		}

		return file_get_contents( $path );
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
