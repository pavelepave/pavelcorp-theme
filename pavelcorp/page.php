<?php 
$context = Timber::get_context();
$context['page'] = new TimberPost();

get_header();
Timber::render( 'templates/page.twig', $context );
get_footer();
?>