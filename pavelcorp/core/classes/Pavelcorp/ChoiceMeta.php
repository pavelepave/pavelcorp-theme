<?php 

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* RadioMeta
*/
class ChoiceMeta extends Meta
{

	public function __construct(
		$name, 
		$description, 
		$post_type, 
		$options = array()
	) {
		parent::__construct( $name, $description, $post_type, $options );

		$this->choices = ( isset($options['choices']) && is_array($options['choices']) ) ? $options['choices'] : array();

	}

	public function show_meta($post) {

		$meta = get_post_meta( $post->ID, $this->name, true );

		// Sanitize meta
		if (empty($meta)) {
			$meta = array();
		} else if ( !is_array($meta) ) {
			$meta = array( $meta );
		} ?>

		<p><?php

			foreach ($this->choices as $value => $name) { ?>
				<label for = "<?php echo $this->name . '-' . $value ; ?>">
					<input 
						type = "checkbox" 
						name = "<?php echo $this->name; ?>[<?php echo $value ?>]"
						id = "<?php echo $this->name . '-' . $value ; ?>"
						value="<?php echo $value ?>"
						<?php if ( in_array($value, $meta) ): ?>
							checked
						<?php endif ?>
						/>
					<?php echo $name; ?>
				</label>
				<?php
			}?>
		</p>
		<?php
	}
}