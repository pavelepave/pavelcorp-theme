<?php 

Namespace Pavelcorp;

use TimberSite;
use TimberMenu;
use TimberPost;
use Twig_Extension_StringLoader;
use Twig_SimpleFilter;


/**
 * StarterSite
 */
class StarterSite extends TimberSite {

	function __construct($agent) {

		$this->agent = $agent;

		// Add Menu Support
		add_theme_support('menus');

		// Add Thumbnail Theme Support
		add_theme_support('post-thumbnails');
		add_image_size('xl', 1220, '', true); // xLarge Thumbnail
		add_image_size('lg', 850, '', true); // Large Thumbnail
		add_image_size('md', 650, '', true); // Medium Thumbnail
		add_image_size('sm', 420, '', true); // Small Thumbnail
		add_image_size('xs', 120, '', true); // Extra Small Thumbnail

		// Localisation Support
		load_theme_textdomain('pavelcorp', get_template_directory() . '/languages');

		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		
		parent::__construct();
	}

	function add_to_context( $context ) {

		$context['page'] = new TimberPost();
		
		$context['postUrl'] = esc_url( admin_url('admin-post.php') );
		$context['wp_title'] = wp_title('', false);
		
		$context['blogname'] = get_bloginfo('name', 'display');
		$context['blogdes'] = get_bloginfo('description', 'display');
		
		$context['charset'] = get_bloginfo('charset', 'display');

		return $context;
	}


	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );

		return $twig;
	}

}