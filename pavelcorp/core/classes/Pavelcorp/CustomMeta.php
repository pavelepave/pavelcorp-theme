<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* TableMeta 
*/
class CustomMeta extends Meta
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
    $options = (object)$this->options;
    $shape = isset($options->shape) ? $options->shape : array(
      'image' => 'image', 
      'title' => 'text', 
      'content' => 'editor',
    );

    $meta = (array)get_post_meta( $post->ID, $this->name, true ); ?>
    <div class="GroupContainer">
      <p>
        <div class="MetaGroups" 
          data-shape="<?php echo esc_attr(json_encode($shape)); ?>"
          data-name="<?php echo $this->name; ?>"><?php
        if ($meta && sizeof($meta) > 0) {
          $index = 0;
          foreach ($meta as $row) {?>
            <div class="MetaGroup">
              <a class="RemoveRow" href="javascript:{}">[ remove ]</a><?php
                foreach ($shape as $name => $type) {
                  $input_name = $this->name . '[' . $index . '][' . $name . ']';
                  $value = isset($row[$name]) ? $row[$name] : '';
                  $this->e_input($input_name, $value, $type);
                }?>
            </div><?php
            $index++;
          }
        }?>
        </div>
        <a href="javascript:{}" 
          class="AddRow AddCustomRow">
          <?php _e('Add group', 'pavlecorp'); ?>
        </a>
      </p>
      </div>
    <?php 
  }

  /**
   * Create input based on type
   */
  public function e_input($input_name, $value = '', $type = 'text' ) { ?>
    <div><?php
    switch($type) {
      case 'image': 
        image($value, $input_name);
        break;
      case 'editor': ?>
        <textarea class="pvcTinyMCE" name="<?php echo $input_name; ?>">
          <?php echo $value; ?>
        </textarea><?php 
        break;
      case 'checkbox': 
        $id = uniqid(); ?>
        <label class="TableCheckbox" for="<?php echo $id; ?>">
          <input name="<?php echo $input_name; ?>" type="hidden" value="<?php echo $value; ?>"/>
          <input name="_<?php echo $input_name; ?>" type="checkbox"
            id="<?php echo $id; ?>"
            onclick="checkValue(event)"
            <?php if ($value === "on") {?>checked<?php } ?> />
          <span aria-hidden="true"></span>
        </label><?php 
        break;
      case 'text':
      default: ?>
        <input type="text" name="<?php echo $input_name; ?>" 
          value="<?php echo $value; ?>" /><?php 
        break;
    }
    ?></div><?php
  }
}

/**
 * Image input
 */
function image($id, $name) {?>
  <div>
    <div 
      data-info = '{"name": "<?php echo $name; ?>" }'
      class="single-preview preview-zone"><?php
      if ($id) {
        $query_images_args = array(
          'post__in'       => array($id), 
          'post_type' => array('attachment'),
          'post_status' => 'inherit',
          'orderby' => 'post__in',
          'posts_per_page' => 1,
        );

        $query_images = new \WP_Query( $query_images_args );
        foreach ( $query_images->posts as $index => $image ) {
          $type = get_post_mime_type($image->ID);
          $isVideo = videoCheck($type);
          $imgUrl = $isVideo 
                  ? wp_get_attachment_url($image->ID) 
                  : wp_get_attachment_image_src( $image->ID, 'sm' ); ?>
          <div>
            <a class="remove">X</a>
            <input 
              type = "hidden" 
              name = "<?php echo $name; ?>"
              value = "<?php echo $image->ID; ?>" >
          
            <?php if ($isVideo): ?>
              <video src="<?php echo $imgUrl; ?>"/>
            <?php else: ?>
              <img src="<?php echo $imgUrl[0]; ?>"/>  
            <?php endif; ?>
          </div><?php 
        }
      } ?>
    </div>

    <!-- Browse button -->
    <input 
      type="button" 
      class="button single-upload" 
      value="Select image" />
  </div><?php
}