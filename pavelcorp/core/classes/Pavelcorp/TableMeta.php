<?php

Namespace Pavelcorp;

use PavelcorpCore\Meta;

/**
* TableMeta 
*/
class TableMeta extends Meta
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
    $head_rows = (array)$options->head_rows;
    $body_cols = (array)$options->body_cols;

    // Meta
    $meta = (array)get_post_meta( $post->ID, $this->name, true );
    if (!isset($meta['head'])) {$meta['head'] = array();}  
    if (!isset($meta['body'])) {$meta['body'] = array();}  ?>
    <!-- Head -->
    <div class="TableContainer" 
      data-cols="<?php echo esc_attr(json_encode($body_cols)); ?>"
      data-rows="<?php echo esc_attr(json_encode($head_rows)); ?>"
      data-name="<?php echo $this->name; ?>">
      <p><?php
        if(sizeof($head_rows) > 0) {?>
          <h4><?php _e('Table Head', 'pavelcorp'); ?></h4>
          <div class="TableHead"><?php
          $i = 0;
          foreach ($meta['head'] as $row) {
            $j = 0;
            ?><div>
            <a class="RemoveRow" href="javascript:{}" onclick="removeRow(event)">[ remove ]</a>
            <?php foreach ($row as $value) {
              $type = $head_rows[$j];
              $this->e_input($value, $i, $j, $type, TRUE);
              $j++;
            }
            $i++;
            ?></div><?php
          } ?>
          </div>
          <a href="javascript:{}" 
            class="AddRow AddHeadRow" >
            <?php _e('Add column', 'pavlecorp'); ?>
          </a><?php
        }?>
      </p>
      <!-- Body -->
      <p>
        <h4><?php _e('Table row(s)', 'pavlecorp'); ?></h4>
        <div class="TableBody"><?php 
        $i = 0;
        foreach ($meta['body'] as $row) {
          $j = 0;
          ?><div>
          <a class="RemoveRow" href="javascript:{}">[ remove ]</a>
          <?php foreach ($row as $value) {
            $type = $body_cols[$j];
            $this->e_input($value, $i, $j, $type, FALSE);
            $j++;
          }
          $i++;
          ?></div><?php
        }?>
        </div>
        <a href="javascript:{}" 
          class="AddRow AddBodyRow">
          <?php _e('Add new row', 'pavlecorp'); ?>
        </a>
      </p>
    </div
    <?php 
  }

  /**
   * Create input based on type
   */
  public function e_input($value, $i, $j, $type = 'text', $isHead = TRUE ) {
    $name = $isHead ? 'head' : 'body';
    $value = isset($value) ? $value : '';
    $input_name = $this->name . '[' . $name . '][' . $i . '][' . $j .']';
    ?><div class="DynamicTable__Head"><?php
    switch($type) {
      case 'editor': ?>
        <textarea class="pvcTinyMCE" name="<?php echo $input_name; ?>">
          <?php echo $value; ?>
        </textarea>
      <?php break;
      case 'checkbox': 
        $id = $this->name . '-body-' . $i . $j; ?>
        <label class="TableCheckbox" for="<?php echo $id; ?>">
          <input name="<?php echo $input_name; ?>" type="hidden" value="<?php echo $value; ?>"/>
          <input name="_<?php echo $input_name; ?>" type="checkbox"
            id="<?php echo $id; ?>"
            onclick="checkValue(event)"
            <?php if ($value === "on") {?>checked<?php } ?> />
          <span aria-hidden="true"></span>
        </label>
      <?php break;
      case 'text':
      default: ?>
        <input type="text" name="<?php echo $input_name; ?>" 
          value="<?php echo $value; ?>" />
      <?php break;
    }
    ?></div><?php
  }
}