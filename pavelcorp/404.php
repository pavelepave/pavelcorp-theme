<?php 
/**
 * 404 page
 */
$context = Timber::get_context();
get_header();
Timber::render( 'templates/404.twig', $context );
get_footer(); ?>