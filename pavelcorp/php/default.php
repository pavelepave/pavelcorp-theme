<?php 

use \Pavelcorp\Agent;
use \Pavelcorp\StarterSite;

$agent = new Agent('pavelcorp');

$agent->init();

$agent->register_nav(
  array( // Using array to specify more menus if needed
    'header-menu' => __('Header Menu', 'pavelcorp'), // Main Navigation
    'footer-menu' => __('Footer Menu', 'pavelcorp')
  )
);

$agent->add_header_script( 'pavelcorpscripts','main.pavelcorp.js', array() );
$agent->add_header_css( 'pavelcorp', 'main.css');

$supports   = array( 'title', 'editor', 'thumbnail' );
$image_only = array( 'title', 'thumbnail' );
$no_thumb   = array( 'title', 'editor' );

/**
 * Timber general context
 */
$wordpress_site = new StarterSite($agent); ?>