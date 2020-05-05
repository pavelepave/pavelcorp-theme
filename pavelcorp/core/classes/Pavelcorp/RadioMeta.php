<?php 

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* RadioMeta
*/
class RadioMeta extends Meta
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

		$meta = get_post_meta( $post->ID, $this->name, true ); ?>

		<label for="<?php echo $this->name; ?>"><?php echo $this->description; ?></label>

		<p>
			<?php foreach ($this->choices as $choice) {
				$value = $choice['value'];
				$name = $choice['name'];
				$id = $this->name . '-' . $value ; ?>
				<label for = "<?php echo $id; ?>">
					<input 
						type  = "radio" 
						name  = "<?php echo $this->name; ?>"
						id    = "<?php echo $id; ?>"
						value = "<?php echo $value ?>"
						<?php if ( $meta == $value): ?>
							checked
						<?php endif ?>
						/>
					<?php echo $name; ?>
				</label>
			<?php } ?>
		</p><?php
	}
}