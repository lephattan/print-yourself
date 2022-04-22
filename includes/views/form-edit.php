<?php
defined('ABSPATH') or die('No script kiddies please!');
$value = get_post_meta($object->ID, PRY_FORM_META_KEY, true);

$json_decode = json_decode($value);

$value = json_encode($json_decode);


wp_nonce_field('pry_meta_box_nonce', 'pry_box_nonce');
?>
<textarea name="pry_fb-editor-json" style="width:100%; min-height: 200px;" id="pry_fb-editor-json"><?php echo $value;?></textarea>
<div id="pry-editor"></div>
<script src="<?php echo plugin_dir_url(PRY_FILE).'assets/js/form-editor.js';?>"></script>

