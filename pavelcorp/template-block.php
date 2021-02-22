<?php
/**
 * Template name: Blocks
 */ 
$context = Timber::get_context();
$context['page'] = new TimberPost();

get_header();
Timber::render( 'templates/blocks.twig', $context );
get_footer();
?>