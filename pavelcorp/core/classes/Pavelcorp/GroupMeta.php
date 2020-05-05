<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
 * GroupMeta 
 */

class GroupMeta extends Meta {
	public function __construct(
		$name, 
		$description, 
		$post_type, 
		$options = array()
	) {
		parent::__construct( $name, $description, $post_type, $options );

		$this->metas = (isset($options['metas']) && is_array($options['metas'])) ? $options['metas'] : array();

		$this->size = (isset($options['size']) && !empty($options['size'])) ? $options['size'] : 0;
	}

	public function show_meta($post){

		$meta = get_post_meta( $post->ID, $this->name, true ); ?>

		<div class="meta-nest"><?php

		foreach ($this->metas as $key => $meta_opt) {

			$meta_name = $this->name . '[' . $meta_opt->name . ']';

			$meta_val = isset($meta[ $meta_opt->name ]) ? $meta[ $meta_opt->name ] : ''; 

			if (!empty($meta_opt->options['default']) && $meta_val == '') {
				$meta_val = $meta_opt->options['default'];
			} ?>

			<h4><?php echo $meta_opt->title; ?></h4>
			
			<?php switch ($meta_opt->type) {
				case 'group':
					$this->group($meta_name, $meta_val, $meta_opt->options['metas']);
					break;
				case 'button':
					$this->button($meta_name, $meta_val);
					break;
				case 'text':
					$this->text($meta_name, $meta_val);
					break;
				case 'radio':
					$this->radio($meta_name, $meta_val, $meta_opt->options['choices']);
					break;
				case 'editor':
					$this->editor($meta_name, $meta_val);
					break;
				case 'image':
					$this->image($meta_name,$meta_val);
					break;
				case 'video':
					break;
				case 'sql_post':
					$this->sql_post($meta_name,$meta_val, $meta_opt->options);
					break;
			} ?><br/><?php
		} ?>
		</div><?php
	}

	private function group($meta_name, $meta_val, $metas)
	{
		?><div class="nested-meta"><?php
			foreach ($metas as $meta) {
				?><h5><?php echo $meta->title; ?></h5><?php

				$name = $meta_name . '[' . $meta->name . ']';
				$value = isset($meta_val[ $meta->name ]) ? $meta_val[ $meta->name ] : '';

				if (!empty($meta->options['default']) && $value == '') {
					$value = $meta->options['default'];
				}

				switch ($meta->type) {
					case 'button':
						$this->button($name, $value);
						break;
					case 'text':
						$this->text($name, $value);
						break;
					case 'radio':
						$this->radio($name, $value, $meta->options['choices']);
						break;
					case 'editor':
						$this->editor($name, $value);
						break;
					case 'image':
						$this->image($name,$value);
						break;
					case 'video':
						break;
				}
			}
		?></div><?php
	}

	private function sql_post($meta_name, $meta_val, $options) {
		$post_query   = new \WP_Query();
		$args = ( isset($options['args']) && is_array($options['args']) ) ? $options['args'] : array();
		$query_result = $post_query->query( $args ); ?>

		
		<div style="display: flex; flex-wrap: wrap;">
			<select name = "<?php echo $meta_name; ?>" 
							value = "<?php echo $meta_val; ?>">
				<option value="" default>Aucun</option>
				<?php foreach ( $query_result as $post_r ) { ?>
						<option 
							<?php if ($meta_val == $post_r->ID): ?>selected<?php endif ?>
							value="<?php echo $post_r->ID ?>"><?php echo $post_r->post_title; ?></option>
				<?php } ?>
			</select>
		</div><?php
	}

	private function text($meta_name, $meta_val)
	{
		?><p>
			<input type="text" name="<?php echo $meta_name; ?>" id="<?php echo $meta_name; ?>" class="meta-video regular-text" value="<?php echo $meta_val; ?>"/>
		</p><?php
	}
	private function button($meta_name, $meta_val)
	{
		?><p>
			<span>Button text:</span> 
			<input 
				type="text" 
				name="<?php echo $meta_name; ?>[text]" 
				id="<?php echo $meta_name; ?>[text]" 
				class="meta-video regular-text" 
				value="<?php echo $meta_val['text']; ?>"/>
		</p>
		<p>
			<span>Button link:</span>
			<input 
				type="text" 
				name="<?php echo $meta_name; ?>[link]" 
				id="<?php echo $meta_name; ?>[link]" 
				class="meta-video regular-text" 
				value="<?php echo $meta_val['link']; ?>"/>
		</p><?php
	}

	private function radio($meta_name, $meta_val, $choices) 
	{
		?><p><?php foreach ($choices as $choice) {
				if (is_array($choice)) {
					$value = $choice['value'];
					$name = $choice['name'];
				} else {
					$value = $choice->value;
					$name = $choice->name;
				} ?>
				<label for="<?php echo $meta_name . '-' . $value ; ?>">
					<?php echo $name; ?>
					<input 
						type="radio" 
						name="<?php echo $meta_name; ?>"
						id="<?php echo $meta_name . '-' . $value ; ?>"
						value="<?php echo $value ?>"
						<?php if ( $meta_val == $value): ?>
							checked
						<?php endif ?>
						/>
				</label>
			<?php } ?>
		</p><?php
	}

	private function editor($meta_name,$meta_val)
	{
		global $post;

		$settings = array(
			'textarea_name' => $meta_name,
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'    => '<style>.wp-editor-area{height:175px; width:100%;}</style>',
		);
		Agent::wp_editor( $meta_val, str_replace(array('[', ']'), '_', $meta_name), $settings );
	}

	private function image($name, $meta)
	{
		$uri = $this->clean_url($meta);
		?><p>
			<input 
				type="hidden" 
				name="<?php echo $name; ?>" 
				id="<?php echo $name; ?>" 
				class="meta-video regular-text" 
				value="<?php echo $uri; ?>"
			/>
			<input 
				type="button" 
				class="button video-upload" 
				value="Browse"
			/>
		</p>
		<div class="video-preview">
			<?php if ($meta): ?>
				<img 
					style="max-width: 250px; box-shadow: 1px 2px 4px 0 #324664" 
					src="<?php echo $uri; ?>"
				/>
			<?php endif; ?>
		</div><?php
	}

}