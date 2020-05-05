<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* PostMeta 
*/
class SQLMeta extends Meta
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

				$meta         = get_post_meta( $post->ID, $this->name, true );
				$post_query   = new \WP_Query();
				$query_result = $post_query->query( $this->args ); ?>

				
				<div style="display: flex; flex-wrap: wrap;">
					<select name = "<?php echo $this->name; ?>" 
									value = "<?php echo $meta; ?>">
						<option value="" default><?php __('None', 'pavelcorp') ?></option>
						<?php foreach ( $query_result as $post_r ) { ?>
							<option 
								<?php if ($meta == $post_r->ID): ?>selected<?php endif ?>
								value="<?php echo $post_r->ID ?>"><?php echo $post_r->post_title; ?></option>
						<?php } ?>
					</select>
				</div><?php
		}
}

