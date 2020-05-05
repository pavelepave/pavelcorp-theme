<?php 

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
 * SelectMeta
 */
class SelectMeta extends Meta
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

      <label for="<?php echo $this->name; ?>">
        <?php echo $this->description; ?>        
      </label>

      <p>
	    	<select 
	    		id = "<?php echo $this->name; ?>" 
	    		name = "<?php echo $this->name; ?>">
	    		<option disabled>Select an option</option>
	    	<?php
			    foreach ($this->choices as $choice) {
			    	$value = $choice['value'];
			    	$name = $choice['name']; ?>
			    	<option 
		        	<?php if ($meta == $value): ?> selected <?php endif; ?>
		        	value="<?php echo $value; ?>">
		        	<?php echo $name; ?>	
		        </option><?php
			    }?>
			 	</select>
    	</p><?php
    }
}