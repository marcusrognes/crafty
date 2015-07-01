<?php
/**
 * The main class file.
 *
 * @package crafty
 */

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
	 * @var string
	 */
	private $version;

	/**
	 * @var array
	 */
	private $global_args;

	/**
	 *
	 */
	function __construct() {
		self::$instance = $this;
		$this->version  = '0.0.1';
		$this->add_image_sizes();
		$this->setup_global_args();
		$this->load_dependencies();
		$this->add_actions();
		$this->add_filters();
	}

	public function add_image_sizes(){
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'banner-large', 1024, 140, true );
		add_image_size( 'banner-medium', 512, 70, true );
		add_image_size( 'banner-small', 256, 35, true );
	}

	/**
	 * Same as get_posts() but converts to the correct model.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function get_posts( $args = array() ) {
		return Post::query( $args );
	}


	/**
	 * Prints the view with global and passed arguments.
	 *
	 * @param string $template
	 * @param array $args
	 */
	public function render( $template = '', $args = array() ) {
		$args = wp_parse_args( $args, $this->global_args );
		echo $this->mustache->render( $template, $args );
	}

	/**
	 * Returns a wp_nav_menu as a string.
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function get_menu( $args = array() ) {
		ob_start();
		wp_nav_menu( $args );

		return ob_get_clean();
	}

	/**
	 * Sets up the views that should be accessible in js.
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
	 * Sets up all the main theme actions.
	 */
	public function add_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_header', array( $this, 'setup_global_args' ) );
		add_action( 'wp_footer', array( $this, 'setup_js' ) );
	}


	/**
	 * Sets up all the main theme filters.
	 */
	public function add_filters() {

	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'crafty-blocking', get_template_directory_uri() . '/static/js/blocking.js', array( 'jquery' ), $this->version );
		wp_enqueue_style( 'crafty-blocking', get_template_directory_uri() . '/static/css/blocking.css', null, $this->version );
		wp_localize_script( 'crafty-blocking', 'craftyBlocking', array(
			'themeUri' => get_template_directory_uri()
		) );
	}

	/**
	 * Converts an array with posts to the theme post model.
	 *
	 * @param WP_Post[] $posts
	 *
	 * @return Post[]
	 */
	public function process_posts_array( $posts ) {
		$new_posts = array();
		foreach ( $posts as $post ) {
			array_push( $new_posts, $this->process_post( $post ) );
		}

		return $new_posts;
	}

	/**
	 * Converts one wp_post to post.
	 *
	 * @param WP_Post $post
	 *
	 * @return Post
	 */
	public function process_post( $post ) {
		return Post::from_wp_post( $post );
	}


	/**
	 * Prints the header markup and runs the wordpress wp_header().
	 */
	public function header() {
		echo '<html>';
		echo '<meta charset="' . get_bloginfo( 'charset' ) . '"/>';
		echo '<meta name="google-site-verification" content="tV4at60q4L2wDK1vZwmYCZgWfaREsx_Rr9YCjPk_ENs"/>';
		echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_attr( get_template_directory_uri() ) . '/static/images/favicon.ico"/>';
		echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo( 'name' ) . ' RSS Feed" href="' . get_bloginfo( 'rss2_url' ) . '"/>';
		echo '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '"/>';
		echo '<title>';
		if ( is_front_page() ) {
			bloginfo( 'name' );
			echo ' | ';
			bloginfo( 'description' );
		} else if ( is_search() ) {
			bloginfo( 'name' );
			echo ' |  Search Result';
		} else {
			global $post;
			bloginfo( 'name' );
			echo ' | ' . get_the_title( $post->ID );
		}
		echo '</title>';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>';
		echo '<body class="' . implode( ' ', get_body_class() ) . '">';
		wp_head();
	}

	/**
	 * Prints the footer markup and runs the wordpress wp_footer().
	 */
	public function footer() {
		wp_footer();
		echo '</body></html>';
	}

	/**
	 * Singleton method.
	 *
	 * @return Crafty_Theme
	 */
	public static function get_instance() {
		if ( isset( self::$instance ) ) {
			return self::$instance;
		}

		self::$instance = new self();

		return self::$instance;
	}


	/**
	 * Sets up dependencies.
	 */
	private function load_dependencies() {
		require_once( realpath( dirname( __FILE__ ) . '/../' ) . '/vendor/autoload.php' );
		require_once( realpath( dirname( __FILE__ ) . '/../' ) . '/lib/models/post.class.php' );
		require_once( realpath( dirname( __FILE__ ) . '/../' ) . '/lib/crafty-theme-js.class.php' );

		$this->mustache = new Mustache_Engine( array(
			'loader' => new Mustache_Loader_FilesystemLoader( realpath( dirname( __FILE__ ) . '/../' ) . '/views', array( 'extension' => '.ms' ) )
		) );
	}

	/**
	 * Gets a view as plain text.
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	private function get_raw_view( $path = '' ) {
		if ( ! file_exists( $path ) ) {
			return '';
		}

		return file_get_contents( $path );
	}

	/**
	 * Gets a view inside a set up script tag.
	 *
	 * @param array $views
	 *
	 * @return string
	 */
	private function get_js_ready_views( $views ) {
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

		$data .= '<script>var CraftyData = ' . json_encode( $this->global_args ) . ';</script>';

		return $data;
	}

	/**
	 * Set global view variables here.
	 */
	public function setup_global_args() {
		$this->global_args['menu']         = wp_nav_menu( array( 'echo' => false ) );
		$this->global_args['template_url'] = get_template_directory_uri();
		$this->global_args['site_title']   = get_bloginfo( 'name' );
		$this->global_args['home_url']     = get_home_url();
	}

}
