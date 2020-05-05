<?php
Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* ImageMeta 
*/
class GalleryMeta extends Meta
{

	public function __construct(
		$name, 
		$description, 
		$post_type,
		$options = array()
	) {
		parent::__construct( $name, $description, $post_type, $options );
	}

	public function show_meta($post) {

		$meta = get_post_meta( $post->ID, $this->name, true ); ?>

		<!-- Gallery -->
		<div 
			data-info = '{"name": "<?php echo $this->name; ?>" }'
			class="gallery-preview">
			<?php
			if (is_array($meta) && count($meta) > 0) {
				$query_images_args = array(
					'post__in' 		 => array_values($meta), 
					'post_type' => array('attachment'),
					'post_status' => 'inherit',
					'orderby' => 'post__in',
					'posts_per_page' => 25,
				);

				$query_images = new \WP_Query( $query_images_args );
				foreach ( $query_images->posts as $index => $image ) {
					$imgUrl = wp_get_attachment_image_src( $image->ID, 'sm' ); ?>
					<div>
						<a class="remove">X</a>
						<input 
							type = "hidden" 
							name = "<?php echo $this->name; ?>[<?php echo $index; ?>]"
							value = "<?php echo $image->ID; ?>" >
					
						<img src="<?php echo $imgUrl[0]; ?>">	
					</div>
				<?php }
			} ?>
		</div>

		<!-- Browse button -->
		<input 
			type="button" 
			class="button gallery-upload" 
			value="Browse" />
		<?php
	}
}
