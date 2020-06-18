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

		$meta = (array)get_post_meta( $post->ID, $this->name, true ); 
		if (isset($this->options['default'])) {
			$default = (array)$this->options['default'];
			
			if (!isset($meta['text']))
				$meta['text'] = isset($default['text']) ? $default['text'] : NULL;
			if (!isset($meta['link']))
				$meta['link'] = isset($default['link']) ? $default['link'] : NULL;
			if (!isset($meta['extern']))
				$meta['extern'] = isset($default['extern']) ? $default['extern'] : NULL;
			if (!isset($meta['page']))
				$meta['page'] = isset($default['page']) ? $default['page'] : NULL;
		} 

		$text = isset($meta['text']) ? $meta['text'] : '';
		$link = isset($meta['link']) ? $meta['link'] : '';
		$extern = isset($meta['extern']) ? $meta['extern'] : false;
		$button_page = isset($meta['page']) ? $meta['page'] : 0; 
		print_r($meta);?>

		<p>
			<label><?php _e('Button','pavelcorp'); ?>:</label>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[text]" 
				class = "regular-text" 
				placeholder = "Text"
				value = "<?php echo $text; ?>"/>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[link]" 
				class = "regular-text"
				placeholder = "https://" 
				value = "<?php echo $link; ?>"/>
			<span><?php _e('or','pavelcorp'); ?>: </span>
      <?php
        $query_pages_args = array(
            'post_type' => array('page'),
            'orderby' => 'post_title',
            'posts_per_page' => -1,
          );
  
          $query_pages = new \WP_Query( $query_pages_args );
      ?> 
      <select name  = "<?php echo $this->name; ?>[page]" >
          <option value=""><?php _e('Select page','pavelcorp'); ?></option>
          <?php foreach ($query_pages->posts as $page) { ?>
          <option 
            value="<?php echo $page->ID; ?>"
            <?php if(isset($button_page) && $button_page == $page->ID): echo "selected"; endif; ?>>
            <?php echo $page->post_title; ?>
          </option>
          <?php } ?>
      </select>
		</p>
		<p>
			<label><?php _e('External link','pavelcorp'); ?>: </label>
			<input 
				type  = "checkbox" 
				name  = "<?php echo $this->name; ?>[extern]" 
				class = "regular-text" 
				value = "<?php echo $extern; ?>"/>
		</p><?php
	}
}