<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* EditorMeta 
*/

class EditorMeta extends Meta {
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

		if (!empty($this->options['default']) && empty($meta)) {
			$meta = $this->options['default'];
		}

		$editor_settings = array(
      'wpautop' => true,
      'media_buttons' => false,
      'textarea_name' => $this->name . '[]',
      'textarea_rows' => 10,
      'teeny' => true
    );
		
		Agent::wp_editor( $meta, $this->name .'-'. $post->ID, $settings );
	}

}