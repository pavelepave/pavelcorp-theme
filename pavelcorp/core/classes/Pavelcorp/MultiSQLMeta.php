<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* PostMeta 
*/
class MultiSQLMeta extends Meta
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
        <style>
          .PostCheckbox {
            display: inline-block;
          }

          .PostCheckbox label {
            display: inline-block;
            padding: 2px 8px 4px;
            
            border-radius: 18px;
            border: 1px solid;

            margin-right: 8px;
            margin-bottom: 8px;

            color: #000;
          }

          .PostCheckbox input {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            display: block;
            width: 0;
            height: 0;
            
            overflow: hidden;
            visibility: hidden;

            margin: 0;
            padding: 0;
            border: none;
          }

          .PostCheckbox input[checked] + label,
          .PostCheckbox input:checked + label  {
            color: #fff;
            background-color: #000;
          }

        </style>
				<div>
          <?php 
          foreach ( $query_result as $post_r ) { ?>
            <div class="PostCheckbox">
              <input
                type="checkbox" 
                name = "<?php echo $this->name; ?>[]" 
                value = "<?php echo $post_r->ID; ?>"
                id = "<?php echo $this->name . '-' . $post_r->ID; ?>" 
                <?php if (in_array($post_r->ID, $meta) ):?>checked<?php endif; ?> />
              <label 
                for="<?php echo $this->name . '-' . $post_r->ID; ?>">
                <?php echo $post_r->post_title; ?> 
              </label>
            </div>
						<?php } ?>
				</div><?php
		}
}

