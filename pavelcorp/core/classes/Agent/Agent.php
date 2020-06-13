<?php

Namespace Pavelcorp;

use \Exception;
use \stdClass;
use \WP_Query;
/**
 * PavelcorpModule
 */
class Agent
{
	static $namespace = 'web/api/v1';

	static public $Metas = array(
		'sql_post' => '\Pavelcorp\SQLMeta',
		'multi_sql_post' => '\Pavelcorp\MultiSQLMeta',
		'text' => '\Pavelcorp\TextMeta',
		'radio' => '\Pavelcorp\RadioMeta',
		'image' => '\Pavelcorp\ImageMeta',
		'video' => '\Pavelcorp\VideoMeta',
		'editor' => '\Pavelcorp\EditorMeta',
		'button' => '\Pavelcorp\ButtonMeta',
		'group' => '\Pavelcorp\GroupMeta',
		'post' => '\Pavelcorp\PostMeta',
		'checkbox' => '\Pavelcorp\ChoiceMeta',
		'select' => '\Pavelcorp\SelectMeta',
		'gallery' => '\Pavelcorp\GalleryMeta',
	);

	/**
	 * @param $site_name String ID/Name of the website
	 */
	function __construct($site_name = "")
	{
		// template directory
		$template_directory = get_template_directory();
		// template URL
		$template_directory_uri = get_template_directory_uri();

		$this->site_name = $site_name;

		// Assets 
		$this->img_dir = $template_directory . '/img';
		$this->css_dir = $template_directory . '/css';
		$this->css_link = $template_directory_uri . '/css/';
		$this->js_dir = $template_directory . '/js';
		$this->js_link = $template_directory_uri . '/js/';

		// Lang vars
		$this->lang = substr( get_locale() , 0, 2 );

		// PHP classes
		$this->classes = $template_directory . '/core/classes';
		
	}

	private $scripts = array();

	private $css = array();

	private $mimes = array();

	private $post_types = array();

	private $routes = array();

	private $timber_context = array();


	/**
	 * Init function
	 */
	public function init()
	{

		// require core classes 
		$this->require_core();

		// require derived classes
		$this->require_classes();

		// SVG Mime Type
		$this->add_mime_type( 'svg', 'image/svg+xml' );

		// add action hooks
		$this->add_hooks();

	}

	/**
	 * Register hook(s)
	 */
	private function add_hooks()
	{
	  add_action('admin_enqueue_scripts', array($this, 'image_meta_script'));

	  // already visited cookie
	  add_action('init', array( $this, 'add_visited_cookie' ));

	  // custom menus
	  add_action('init', array($this, 'register_initial_nav'));

	  // JS scritps
	  add_action('init', array($this, 'header_scripts'));

	  // custom post types
	  add_action('init', array( $this, 'custom_post_type' ));

	  // CSS stylesheets
	  add_action('wp_enqueue_scripts', array($this, 'header_css'));

	  // Mime Types
	  add_filter('upload_mimes', array( $this, 'cc_mime_types'));

	  // mail content type
	  add_filter( 'wp_mail_content_type', array( $this, 'mail_content_type' ));

	  // api routes
	  add_action( 'rest_api_init', array($this, 'register_routes'));

	}

	/**
	 * Script to pick image to pick from uploaded assets
	 * Used by ImageMeta.php
	 */
	public function image_meta_script($hook)
	{
		global $post;

		if ( is_admin() && $hook == 'post-new.php' || $hook == 'post.php' ) {
     wp_register_script(  'image-meta', get_template_directory_uri() . '/core/classes/Agent/script-image-meta.js' );
     wp_register_script(  'gallery-meta', get_template_directory_uri() . '/core/classes/Agent/script-gallery-meta.js' );
     
     wp_enqueue_style(  'css-meta', get_template_directory_uri() . '/core/classes/Agent/script-css.css' );

     wp_enqueue_media();
     wp_enqueue_script('image-meta');
     wp_enqueue_script('gallery-meta');

		}
	}


	/**
	 * Attached to rest_api_init by add_action()
	 */
	public function register_routes() {
		foreach ($this->routes as $route => $args) {
			register_rest_route(
				self::$namespace,
				$route,
				$args
			);
		}
	}

	/**
	 * Register a new route
	 *
	 * @param $route String Pathname  
	 * @param $args Array Arguments (callback(s))
	 */
	public function register_route($route, $args) 
	{
		$this->routes[$route] = $args; 
	}

	/**
	 *  WP Editor
	 *
	 * @param $content String Text content
	 * @param $editor_id String Editor id attribute
	 * @param $settings Array Editor settings
	 * @return WP_Editor Wordpress text editor
	 */
	static public function wp_editor( $content, $editor_id, $settings )
	{
		wp_editor( htmlspecialchars_decode( $content, ENT_QUOTES ), $editor_id, $settings );
	}

	/**
	 *  Attached to init by add_action
	 *  Register saved custom post types
	 */
	public function custom_post_type()
	{
		foreach ($this->post_types as $post_type) {
			$this->create_post_type( $post_type[0], $post_type[1], $post_type[2], $post_type[3] );
		}
	}

	/**
	 *  Save a new post type
	 *
	 * @param $type String Post type uniq ID
	 * @param $name Post type display name
	 * @param $supports String Post type features
	 * @param $options Array Post type options
	 */
	public function add_post_type($type, $name, $supports, $options = array())
	{
		$this->post_types[] = array($type, $name, $supports, $options);
	}

	/**
	 *  Create a new Post type
	 *
	 * @param $type String Post type uniq ID
	 * @param $name Post type display name
	 * @param $supports String Post type features
	 * @param $options Array Post type options
	 */
	private function create_post_type($type, $name, $supports, $options = array())
	{
		$options['category'] = ( isset( $options['category'] ) ) ? $options['category'] : false;

		$options['post_tag'] = ( isset( $options['post_tag'] ) ) ? $options['post_tag'] : false;

		$taxonomies = isset( $options['taxonomies'] ) && !empty( $options['taxonomies'] ) ? $options['taxonomies'] : array();

		// Enable categories
		if ($options['category']) {
			register_taxonomy_for_object_type('category', $type); // Register Taxonomies for Category
			$taxonomies[] = 'category';
		}

		// Enable post tags
		if ($options['post_tag']) {
			register_taxonomy_for_object_type('post_tag', $type);
			$taxonomies[] = 'post_tag';
		}

		// Show in /wp-json/v2
		$show_in_rest = isset($options['show_in_rest']) 
									? $options['show_in_rest'] : false;

		// Has template
		$publicly_queryable = isset($options['publicly_queryable']) 
												? $options['publicly_queryable'] : false;

		register_post_type($type, // Register Custom Post Type
			array(
			'labels' => array(
				'name' => __( $name, 'pavelcorp'), // Rename these to suit
				'singular_name' => __($name, 'pavelcorp'),
				'add_new' => __('Add New', 'pavelcorp'),
				'add_new_item' => __('Add New post', 'pavelcorp'),
				'edit' => __('Edit', 'pavelcorp'),
				'edit_item' => __('Edit Post', 'pavelcorp'),
				'new_item' => __('New Post', 'pavelcorp'),
				'view' => __('View Post', 'pavelcorp'),
				'view_item' => __('View  Post', 'pavelcorp'),
				'search_items' => __('Search Post', 'pavelcorp'),
				'not_found' => __('No Posts found', 'pavelcorp'),
				'not_found_in_trash' => __('No Posts found in Trash', 'pavelcorp')
			),
			'rewrite' => array('slug' => $type, 'with_front' => false),
			'show_in_rest' => $show_in_rest,
			'public' => true,
			'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
			'has_archive' => true,
			'supports' => $supports, // Go to Dashboard Custom HTML5 Blank post for supports
			'can_export' => true, // Allows export in Tools > Export
			'taxonomies' => $taxonomies, // Add Category and Post Tags support
			'publicly_queryable' => $publicly_queryable,
		));
	}

	/**
	 * Add a cookie to new visitor
	 */
	public function add_visited_cookie() 
	{
		$days_to_expire = 7;

		if (!is_admin() && !isset($_COOKIE['alreadyVisited'])) {
			setcookie('already_visited', true, time() + 86400 * $days_to_expire);
		}
	}

	/**
	 * Attached to wp_mail_content_type by add_filter   
	 * Set html as default mail content type
	 */
	public function mail_content_type(){
		return "text/html";
	}

	/**
	 *  Register a custom Mime Type
	 *
	 * @param $mime String Mime type id
	 * @param $type String Custom mime type
	 */
	public function add_mime_type($mime, $type) {
		$this->mimes[] = array($mime, $type);
	}

	/**
	 * Add all registered mime types
	 * Attached to upload_mimes by add_filter
	 *
	 * @param $mimes Array Array of mime types
	 */
	public function cc_mime_types($mimes) {
		foreach ($this->mimes as $key => $mime) {
			$mimes[ $mime[0] ] = $mime[1];
		}

		return $mimes;
	}

	/**
	 *  Create new custom meta
	 *
	 * @param $post_type String Post type ID to link meta
	 *
	 * @param $meta->options Array Custom meta otpions
	 * @param $meta->type String Custom meta type ID
	 * @param $meta->name String Custom meta name
	 * @param $meta->title String Custom meta display name
	 *
	 * @return Meta Custom meta field
	 */
	static public function create_meta($post_type, $meta)
	{
		$meta->options = ( isset($meta->options)  && is_array($meta->options) ) ? $meta->options : array();


		return new self::$Metas[$meta->type]( $meta->name, $meta->title, $post_type, $meta->options );
	}

	/**
	 *  Register a new stylesheet
	 *
	 * @param $name String Stylesheet uniq ID
	 * @param $file String File name
	 * @param $dep Array Dependencies
	 */
	public function add_header_css($name, $file, $dep = array())
	{
		$this->css[] = array($name, $file, $dep);
	}

	/**
	 * Attached to wp_enqueue_scripts by add_action 
	 * Register all stylesheets
	 */
	public function header_css()
	{           
		foreach ($this->css as $script) {
			wp_register_style($script[0], $this->css_link . $script[1], $script[2] || array(), '1.0.0');
			wp_enqueue_style($script[0]);
		}
	}

	/**
	 *  Register a javascript file
	 *
	 * @param $name String Script uniq ID
	 * @param $file String File name
	 * @param $dep Array Dependencies
	 */
	public function add_header_script($name, $file, $dep = array())
	{
		$this->scripts[] = array($name, $file, $dep);
	}

	/**
	 * Attached to init by add_action   
	 * Register all scripts
	 */
	public function header_scripts()
	{
	  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
			foreach ($this->scripts as $script) {
				wp_register_script($script[0], $this->js_link . $script[1], $script[2], '1.0.0');
				wp_set_script_translations($script[0], 'pavelcorp', get_template_directory() . '/languages' );

				wp_enqueue_script($script[0]);              
			}
		}
	}

	/**
	 * Register a custom navbar  
	 * 
	 * @param $nav Array Navbar array name -> display name
	 */
	public function register_nav($nav){
		$this->nav = $nav;
	}

	/**
	 * Attached to init by add_action
	 * Register all custom navbar(s)
	 */
	public function register_initial_nav()
	{
		register_nav_menus( $this->nav );
	}

	/**
	 * Get registered navbar
	 *
	 * @param $location String Navbar ID
	 * @param $class_name String Custom class attribute for menu
	 * @return string|false|void false if there are no items or no menu was found.
	 */
	static public function get_nav($location, $class_name = '') 
	{
		return wp_nav_menu(
			array(
				'theme_location'  => $location,
				'menu'            => '',
				'container'       => 'div',
				'container_class' => '',
				'menu_class'      => '',
				'echo'            => false,
				'fallback_cb'     => 'wp_page_menu',
				'items_wrap'      => '<ul class="'. $class_name .'">%3$s</ul>',
				'depth'           => 0,
			)
		);
	}
	
	/**
	 *  Require all core classes
	 */
	public function require_core()
	{
		$this->p_require( $this->classes . '/Core' );
	}

	/**
	 *  Require extended classes
	 */
	public function require_classes()
	{
		$this->p_require( $this->classes . '/Pavelcorp' );
	}

	/**
	 * Require all file from a directory
	 *
	 * @param $dir String Absolute path to directory
	 */
	private function p_require($dir) 
	{
		$files = array_diff(scandir($dir, 1), array('.', '..', 'index.php'));

		foreach ($files as $file) {
			require_once $dir . '/' . $file;
		}
	}

	/**
	 * Cast meta properties to $meta object that can be used by 
	 * $this->create_meta($post_type, $meta)
	 * @param [type] $type    [description]
	 * @param [type] $name    [description]
	 * @param [type] $title   [description]
	 * @param array  $options [description]
	 */
	public function set_meta($type, $name, $title, $options = array()) {
		return (object) array (
			'type' => $type,
			'name' => $name,
			'title' => $title,
			'options' => $options,
		);
	}
}
