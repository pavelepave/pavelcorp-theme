<?php 
/**
 * Custom single.php file - not included !
 */
include __DIR__ . '/php/custom/single.php'; 

/**
 * Default example:
 * <?php
 * $context = Timber::get_context();
 * $post = $context['page'];
 *
 * switch ($post->post_type) {
 * 	case 'post':
 * 		$context['post'] = $post;
 * 
 * 		get_header();
 * 		Timber::render( 'templates/single.twig', $context );
 * 		get_footer();
 *
 * 		break;
 *	
 * 	default:
 * 		http_response_code(404);
 * 		get_header();
 * 		?>
 * 		<main role="main">
 * 			<div class="wrapper">
 * 				<div class="grid">
 * 					<div class="grid__item">
 * 						<article id="post-404">
 * 
 * 							<h1><?php _e( 'Page not found', 'pavelcorp' ); ?></h1>
 * 							<h2>
 * 								<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'pavelcorp' ); ?></a>
 * 							</h2>
 * 
 * 						</article>
 * 					</div>
 * 				</div>
 * 			</div>
 * 		</main>
 * 	<?php
 * 		get_footer();
 * 		break;
 * }
 * ?>
 */
?>
