<?php 
// Template specific script
function add_404_script() {
	wp_enqueue_style( '404style', get_template_directory_uri() . '/css/custom/notFound.css');
}

add_action( 'wp_enqueue_scripts', 'add_404_script' );
$context = Timber::get_context();
get_header();
Timber::render( 'templates/custom/404.twig', $context );
get_footer(); ?>