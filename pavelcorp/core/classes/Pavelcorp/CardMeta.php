<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* ButtonMeta 
*/
class CardMeta extends Meta
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
    $editor_settings = array(
			'textarea_name' => $this->name,
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'    => '<style>.wp-editor-area{height:175px; width:100%;}</style>',
    );
    
		$meta = (array)get_post_meta( $post->ID, $this->name, true ); 
		if (!empty($this->options['default']) && empty($meta)) {
			$meta = $this->options['default'];
    } 
    $title = isset($meta['title']) ? $meta['title'] : '';
    $content = isset($meta['content']) ? $meta['content'] : '';
    $img = isset($meta['img']) ? $meta['img'] : '';
    $button_text = isset($meta['button_text']) ? $meta['button_text'] : '';
    $button_link = isset($meta['button_link']) ? $meta['button_link'] : '';
    ?>

		<p>
      <label><?php _e('Title', 'pavelcorp'); ?>: </label>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[title]" 
				class = "regular-text" 
        value = "<?php echo $title; ?>" />
    </p>
    <p>
      <label><?php _e('Content', 'pavelcorp'); ?>: </label>
			<?php Agent::wp_editor( $content, $this->name .'-'. $post->ID, $editor_settings ); ?>
    </p>
    <p>
      <label><?php _e('Button', 'pavelcorp'); ?>: </label>
			<input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[button_text]" 
        class = "regular-text" 
        placeholder="<?php _e('Button text', 'pavelcorp'); ?>"
        value = "<?php echo $button_text; ?>" />
      <input 
				type  = "text" 
				name  = "<?php echo $this->name; ?>[button_text]" 
        class = "regular-text"
        placeholder="https://" 
        value = "<?php echo $button_text; ?>" />
      <span><?php _e('or','pavelcorp'); ?>: </span>
      <?php
        $query_pages_args = array(
            'post_type' => array('page'),
            'orderby' => 'post_title',
            'posts_per_page' => -1,
          );
  
          $query_pages = new \WP_Query( $query_pages_args );
      ?> 
      <select name  = "<?php echo $this->name; ?>[button_page]" >
          <option value=""><?php _e('Select page','pavelcorp'); ?></option>
          <?php foreach ($query_pages->posts as $page) { ?>
          <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
          <?php } ?>
      </select>
    </p>
    <p>
      <label><?php _e('Attachement', 'pavelcorp'); ?>: </label>
      <div 
        data-info = '{"name": "<?php echo $this->name; ?>[img]" }'
        class="single-preview">
        <?php
        if ($img) {
          $query_images_args = array(
            'post__in'       => array($img), 
            'post_type' => array('attachment'),
            'post_status' => 'inherit',
            'orderby' => 'post__in',
            'posts_per_page' => 1,
          );
  
          $query_images = new \WP_Query( $query_images_args );
          foreach ( $query_images->posts as $image ) {
            $imgUrl = wp_get_attachment_image_src( $image->ID, 'sm' ); ?>
            <div>
              <a class="remove">X</a>
              <input 
                type = "hidden" 
                name = "<?php echo $this->name; ?>[img]"
                value = "<?php echo $image->ID; ?>" >
            
              <img src="<?php echo $imgUrl[0]; ?>">  
            </div>
          <?php }
        } ?>
      </div>
      <!-- Gallery -->
      <!-- Browse button -->
      <input 
        type="button" 
        class="button single-upload" 
        value="Browse" />
    </p><?php
    
	}
}