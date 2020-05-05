<?php 
/**
 * Remove the <div> surrounding the dynamic navigation to cleanup markup
 */
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

/**
 * Remove Injected classes, ID's and Page ID's from Navigation <li> items
 */
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

/**
 * Remove invalid rel attribute values in the categorylist
 */
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

/**
 * Add page slug to body class, love this - Credit: Starkers Wordpress Theme
 */
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

/**
 * Custom Excerpts
 */
function initialwp_index($length) // Create 20 Word Callback for Index page Excerpts
{
    return 20;
}

/**
 * Create 40 Word Callback for Custom Post Excerpts
 */
function initialwp_custom_post($length)
{
    return 40;
}

/**
 * Create the Custom Excerpts callback
 */
function initialwp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

/**
 * Remove Admin bar
 */
function remove_admin_bar()
{
    return false;
}

/**
 * Remove 'text/css' from our enqueued stylesheet
 */
function initial_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

/**
 * Display the links to the extra feeds such as category feeds
 */
remove_action('wp_head', 'feed_links_extra', 3); 

/**
 * Display the links to the general feeds: Post and Comment Feed
 */
remove_action('wp_head', 'feed_links', 2); 

/**
 * Display the link to the Really Simple Discovery service endpoint, EditURI link
 */
remove_action('wp_head', 'rsd_link'); 

/**
 * Display the link to the Windows Live Writer manifest file.
 */
remove_action('wp_head', 'wlwmanifest_link'); 

/**
 * Index link
 */
remove_action('wp_head', 'index_rel_link'); 

/**
 * Prev link
 */
remove_action('wp_head', 'parent_post_rel_link', 10, 0); 

/**
 * Start link
 */
remove_action('wp_head', 'start_post_rel_link', 10, 0); 

/**
 * Display relational links for the posts adjacent to the current post.
 */
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); 

/**
 * Display the XHTML generator that is generated on the wp_head hook, WP version
 */
remove_action('wp_head', 'wp_generator'); 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * Add slug to body class (Starkers build)
 */
add_filter('body_class', 'add_slug_to_body_class'); 

/**
 * Remove surrounding <div> from WP Navigation
 */
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); 

/**
 * Remove invalid rel attribute
 */
add_filter('the_category', 'remove_category_rel_from_category_list'); 

/**
 * Remove Admin bar
 */
add_filter('show_admin_bar', 'remove_admin_bar'); 

/**
 * Remove 'text/css' from enqueued stylesheet
 */
add_filter('style_loader_tag', 'initial_style_remove'); 