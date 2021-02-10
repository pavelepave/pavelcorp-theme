<?php 
define('ASSET_VERSION', '1.0.1');

use \Pavelcorp\Agent;
use \Pavelcorp\StarterSite;

$agent = new Agent('pavelcorp');

$agent->init();

$agent->register_nav(
  array( // Using array to specify more menus if needed
    'header-menu' => __('Header Menu', 'pavelcorp'), // Main Navigation
    'footer-menu' => __('Footer Menu', 'pavelcorp'),
    'legal-menu' => __('Legal Menu', 'pavelcorp'),
  )
);

$agent->add_header_script( 'pavelcorpscripts','custom/main.pavelcorp.js', array() );
$agent->add_header_css( 'pavelcorp', 'custom/main.css');

// Menu setup
add_filter( 'timber_context', 'pavelcorp_register_menus' );

$supports   = array( 'title', 'editor', 'thumbnail' );
$image_only = array( 'title', 'thumbnail' );
$no_thumb   = array( 'title', 'editor' );

/**
 * Timber general context
 */
$wordpress_site = new StarterSite($agent); 


/**
 * Custom post type
 */
$agent->add_post_type(
  'custom_post_type', 
  __('Custom Post Type', 'pavelcorp'),
  array( 'title', 'thumbnail'),
  array('post_tag' => true, 'publicly_queryable' => true)
);

/**
 * Custom meta fpr custom post type
 */
$agent->create_meta(
  'custom_post_type', 
  (object) array(
    'name' => 'custom_meta',
    'title' => __('Custom Meta','pavelcorp'),
    'type' => 'text',
    'options' => array(),
  )
); 

/**
 * Custom categories / taxonomies
 */
function pavelcorp_custom_taxonomies() {
  // Team category
  register_taxonomy(
    'custom_taxonomy',
    'custom_post_type',
    array(
      'label' => __('Custom Taxnonomy', 'pavelcorp'),
      'rewrite' => array( 'slug' => 'custom_taxonomy'),
      'rest_base' => 'custom_taxonomy',
      'show_in_rest' => false,
      'hierarchical' => true,
    )
  );
}

add_action('init', 'pavelcorp_custom_taxonomies');


/**
 * Manage columns (examples)
 */
add_filter( 'manage_custom_post_type_posts_columns', 'pavelcorp_filter_custom_post_type_columns' );
function pavelcorp_filter_custom_post_type_columns( $columns ) {
  $columns['custom_post_type'] = __( 'Custom Post Type' );
  return $columns;
}

add_action( 'manage_custom_post_type_posts_custom_column', 'pavelcorp_custom_post_type_columns', 10, 2);
function pavelcorp_custom_post_type_columns( $column, $post_id ) {
  // Image column
  if ( 'custom_post_type' === $column ) {
  	// echo smth
  }
}

/**
 * Generate color meta object
 * @param {Array} $choices value => name pair(s)
 */
function color_meta($choices, $name = 'color') {
  $colors = (object) array(
    'name' => $name,
    'title' => __('Pick a color','pavelcorp'),
    'type' => 'select',
    'options' => array(),
  );

  $colors->options = array(
    'choices' => $choices
  );

  return $colors;
}

/**
 * Generate feature meta
 */
function feature_meta($name = 'featured') {
  $featured = (object) array(
    'name' => $name,
    'title' => __('Is featured ?','pavelcorp'),
    'type' => 'checkbox',
    'options' => array(),
  );

  $featured->options = array(
    'choices' => array('yes' => __('Yes','pavelcorp'))
  );

  return $featured;
}

/**
 * Generate template specific meta
 * @param {string} $name Meta name/key
 * @param {string} $template Template name
 */
function template_meta($name, $title, $type, $template, $options = array()) {
  $obj = (object) array(
    'name' => $name,
    'title' => __($title,'pavelcorp'),
    'type' => $type,
    'options' => array(),
  );

  $obj->options = $options;
  $obj->options['template'] = $template;

  return $obj;
}

/**
 * Theme mod
 */
function pavelcorp_customize_register( $wp_customize ) {
  $wp_customize->add_setting( 'portfolio_page' , array(
    'default'   => '',
    'transport' => 'refresh',
  ) );

  $wp_customize->add_section( 'pavelcorp_settings' , array(
    'title'      => __( 'Réglage(s) thème', 'pavelcorp' ),
    'priority'   => 30,
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'portfolio_page', array(
    'type' => 'dropdown-pages',
    'section' => 'pavelcorp_settings', // Add a default or your own section
    'label' => __( 'Portfolio Page' ),
    'description' => __( 'Select Portfolio page' ),
  ) ) );

  $wp_customize->add_setting( 'team_page' , array(
    'default'   => '',
    'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'team_page', array(
    'type' => 'dropdown-pages',
    'section' => 'pavelcorp_settings', // Add a default or your own section
    'label' => __( 'Team Page' ),
    'description' => __( 'Select Team page' ),
  ) ) );

  $wp_customize->add_setting( 'email_addr' , array(
    'default'   => 'contact@serena.vc',
    'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'email_addr', array(
    'type' => 'email',
    'section' => 'pavelcorp_settings', // Add a default or your own section
    'label' => __( 'Contact email' ),
    'description' => __( 'Contact email at the bottom of the footer.' ),
  ) ) );

  $wp_customize->add_setting( 'footer_copyright' , array(
    'default'   => '© 2020 Serena',
    'transport' => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_copyright', array(
    'type' => 'text',
    'section' => 'pavelcorp_settings', // Add a default or your own section
    'label' => __( 'Copyright' ),
  ) ) );
}
add_action( 'customize_register', 'pavelcorp_customize_register' );

/**
 * Menu setup
 */
function pavelcorp_register_menus($context) {
  $context['header'] = new TimberMenu('header-menu');
  $context['footer'] = new TimberMenu('footer-menu');
  $context['legal'] = new TimberMenu('legal-menu');

  return $context;
}

/**
 * Add async attr to scripts
 */
add_filter('script_loader_tag', 'pavelcorp_script_loader_tag', 10, 4);
function pavelcorp_script_loader_tag( $tag, $handle, $src ) {
  if(!is_admin()) {
    if ( 
      strpos($handle, 'async-') !== false ||
      'wp-polyfill' === $handle || 
      'wp-embed' === $handle ||
      'wp-i18n' === $handle
    ) {
      $tag = '<script type="text/javascript" src="' . esc_url( $src ) . '" async></script>';
    }
  }
  return $tag;
}

add_filter('post_row_actions', 'pavelcorp_remove_quick_edit', 10, 1);
add_filter('page_row_actions', 'pavelcorp_remove_quick_edit', 10, 1);
/**
 * Remove quick edit
 */
function pavelcorp_remove_quick_edit($actions) {
  unset($actions['inline hide-if-no-js']);
  return $actions;
}