<?php
Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* ImageMeta 
*/
class ImageMeta extends Meta
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
			class="single-preview">
			<?php
			if ($meta) {
				$query_images_args = array(
					'post__in'       => array($meta), 
					'post_type' => array('attachment'),
					'post_status' => 'inherit',
					'orderby' => 'post__in',
					'posts_per_page' => 1,
				);

				$query_images = new \WP_Query( $query_images_args );
				foreach ( $query_images->posts as $index => $image ) {
					$type = get_post_mime_type($image->ID);
					$isVideo = videoCheck($type);
					$imgUrl = $isVideo 
									? wp_get_attachment_url($image->ID) 
									: wp_get_attachment_image_src( $image->ID, 'sm' ); ?>
					<div>
						<a class="remove">X</a>
						<input 
							type = "hidden" 
							name = "<?php echo $this->name; ?>"
							value = "<?php echo $image->ID; ?>" >
					
						<?php if ($isVideo): ?>
							<video src="<?php echo $imgUrl; ?>"/>
						<?php else: ?>
							<img src="<?php echo $imgUrl[0]; ?>"/>  
						<?php endif; ?>
					</div>
				<?php }
			} ?>
		</div>

		<!-- Browse button -->
		<input 
			type="button" 
			class="button single-upload" 
			value="Browse" />
		<?php
	}
}

// Is video or img
function videoCheck($type) {
	return $type === "video/mp4" || $type === "video/ogg" || $type === "video/webm";
}