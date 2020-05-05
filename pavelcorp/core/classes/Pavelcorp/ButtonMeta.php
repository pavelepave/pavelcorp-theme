<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* ButtonMeta 
*/
class ButtonMeta extends Meta
{

	public function __construct(
		$name, 
		$description, 
		$post_type,
		$options = array()
	) 
	{

		parent::__construct( $name, $description, $post_type, $options );
	}

	public function show_meta($post) {

		$meta = get_post_meta( $post->ID, $this->name, true ); 
		if (!empty($this->options['default']) && empty($meta)) {
			$meta = $this->options['default'];
		} ?>

		<p>
			<label for = "<?php echo $this->name; ?>[text]">
				Button text:
			</label>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[text]" 
				id    = "<?php echo $this->name; ?>[text]" 
				class = "regular-text" 
				value = "<?php echo $meta['text']; ?>"
			/>
		</p>
		<p>
			<label for = "<?php echo $this->name; ?>[link]">
				Button link:
			</label>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[link]" 
				id    = "<?php echo $this->name; ?>[link]" 
				class = "regular-text" 
				value = "<?php echo $meta['link']; ?>"/>
		</p>
		<p>
			<label for = "<?php echo $this->name; ?>[extern]">
				External link ?
			</label>
			<input 
				type  = "checkbox" 
				name  = "<?php echo $this->name; ?>[extern]" 
				id    = "<?php echo $this->name; ?>[extern]" 
				class = "regular-text" 
				value = "<?php echo $meta['extern']; ?>"/>
		</p>
		<?php if (!empty($meta['text'])) : ?>
			<p>
				<label><?php __('Preview', 'pavelcorp'); ?></label>
				<a 
					class  = "button" 
					href   = "<?php echo $meta['link']; ?>"
					target = '_blank'><?php echo $meta['text']; ?></a>
			</p>
		<?php endif;
	}
}