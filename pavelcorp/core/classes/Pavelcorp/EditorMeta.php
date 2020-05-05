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

		if (!empty($options['default']) && empty($meta)) {
			$meta = $options['default'];
		}

		$settings = array(
			'textarea_name' => $this->name,
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'    => '<style>.wp-editor-area{height:175px; width:100%;}</style>',
		);
		
		Agent::wp_editor( $meta, $this->name .'-'. $post->ID, $settings );
	}

}