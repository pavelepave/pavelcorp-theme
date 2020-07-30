<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* PostMeta 
*/
class SQLOrderedMeta extends Meta
{

		public function __construct(
				$name, 
				$description, 
				$post_type,
				$options = array()
		) 
		{
				parent::__construct( $name, $description, $post_type, $options );

				$this->args = ( isset($options['args']) && is_array($options['args']) ) ? $options['args'] : array();
				$this->meta_filter_name = ( isset($options['meta_filter_name']) && !empty($options['meta_filter_name']) ) ? $options['meta_filter_name'] : null;
		}

		public function show_meta($post) {
				if ($this->meta_filter_name) {
						$meta_filter_value = get_post_meta( $post->ID, $this->meta_filter_name, true );
						if ($meta_filter_value) {
								$this->args['meta_key']   = $this->meta_filter_name;
								$this->args['meta_value'] = $meta_filter_value;
						}
        }
        
				$selected     = false;
        $meta         = (array)get_post_meta( $post->ID, $this->name, true );
				$post_query   = new \WP_Query();
        $query_result = $post_query->query( $this->args ); ?>

				<div>
          <?php foreach ( $meta as $user_selected_value ) { 
            if (is_numeric($meta)){ ?>
            <select name = "<?php echo $this->name; ?>[]">
              <option value="">---</option>
              <?php 
              foreach ( $query_result as $post_r ) { ?>
                <option 
                  <?php if ( $post_r->ID == $user_selected_value ):?>selected<?php endif; ?>
                  value="<?php echo $post_r->ID; ?>" >
                  <?php echo $post_r->post_title; ?>
                </option>
                <?php } ?>
            </select>
          <?php }} ?>

          <button 
            data-options="<?php echo htmlspecialchars(json_encode($query_result), ENT_QUOTES, 'UTF-8');?>"
            data-name="<?php echo $this->name; ?>"
            onclick="addNewSelector(event)"
            aria-haspopup="true" 
            aria-expanded="false" 
            class="components-button has-icon" aria-label="Add block">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24" role="img" aria-hidden="true" focusable="false">
              <path d="M10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6zM10 1c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm1-11H9v3H6v2h3v3h2v-3h3V9h-3V6z"></path>
            </svg>
          </button>
				</div><?php
		}
}

