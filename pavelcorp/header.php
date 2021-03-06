<?php  $GLOBALS['timberContext'] = Timber::get_context(); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>

	<?php 
		Timber::render(
			'templates/parts/head.twig', 
			Timber::get_context()
		); 
		wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>
		<div class="body">
			<?php 
				Timber::render(
					'templates/parts/header.twig', 
					Timber::get_context()
				); ?>
