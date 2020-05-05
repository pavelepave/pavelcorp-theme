<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* TextMeta 
*/
class TextMeta extends Meta
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
		
		$meta = get_post_meta( $post->ID, $this->name, true ); 

		if (!empty($options['default']) && empty($meta)) {
			$meta = $options['default'];
		} ?>

		<p>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>" 
				id    = "<?php echo $this->name; ?>" 
				class = "meta-video regular-text" 
				value = "<?php echo $meta; ?>"
			/>
		</p><?php
	}
}