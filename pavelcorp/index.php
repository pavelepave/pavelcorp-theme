<?php 
$context = Timber::get_context();
$context['page'] = new TimberPost();

get_header();
get_footer(); ?>