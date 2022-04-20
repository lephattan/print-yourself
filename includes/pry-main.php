<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


$print_yourself_options = get_option( 'pry_setting' );
if ($print_yourself_options['enable_plugin']) {
  add_action('woocommerce_before_add_to_cart_button','pry_add_custom_fields');
  add_filter('woocommerce_add_cart_item_data','pry_add_item_data',10,3);
  add_filter('woocommerce_get_item_data','pry_add_item_meta',10,2);
  add_action( 'woocommerce_checkout_create_order_line_item', 'pry_add_custom_order_line_item_meta',10,4 );
}

/**
 * Adds custom field for Product
 * @return [type] [description]
 */
function pry_add_custom_fields()
{
  global $product;
  global $print_yourself_options;
  $enable_per_product = $print_yourself_options['enable_per_product'];
  $enable_global = isset($print_yourself_options['enable_global']) ? $print_yourself_options['enable_global'] : false;
  ob_start();
  if($enable_global){
?>
  <div class="pry-custom-fields">
<?php 
    for ($i=1; $i < 4; $i++) { 
      if($print_yourself_options['global_field_'.$i]) {
        $field = $print_yourself_options['global_field_'.$i];
        echo '<label for="pry_global_'.sanitize_title_with_dashes($field).'">Enter your own '.$field.':</label>';
        echo '<input type="text" name="pry_global_'.sanitize_title_with_dashes($field).'">';
            }
        }
?>
  </div>
  <div class="clear"></div>
<?php
    };
    if ($enable_per_product) {
?>
  <div class="pry-custom-fields">
<?php 
      $customizable_fields = wc_get_product_terms( $product->get_id(), 'pa_customizable-fields', array( 'fields' => 'names' ) );
      // print_r($customizable_fields);
      foreach ($customizable_fields as $key => $field) {
        echo '<label for="pry_'.sanitize_title_with_dashes($field).'">Enter your own '.$field.':</label>';
        echo '<input type="text" name="pry_'.sanitize_title_with_dashes($field).'">';
                }
?>
  </div>
  <div class="clear"></div>

<?php
    }

    $content = ob_get_contents();
    ob_end_flush();

    return $content;
}



/**
 * Add custom data to Cart
 * @param  [type] $cart_item_data [description]
 * @param  [type] $product_id     [description]
 * @param  [type] $variation_id   [description]
 * @return [type]                 [description]
 */
function pry_add_item_data($cart_item_data, $product_id, $variation_id)
{
  global $print_yourself_options;
  $enable_per_product = $print_yourself_options['enable_per_product'];
  $enable_global = isset($print_yourself_options['enable_global']) ? $print_yourself_options['enable_global'] : false;
  if($enable_global){
    for ($i=1; $i < 4; $i++) { 
      if($print_yourself_options['global_field_'.$i]) {
        $field = $print_yourself_options['global_field_'.$i];
        if(isset($_REQUEST['pry_global_'.sanitize_title_with_dashes($field)])){
          $cart_item_data['pry_global_'.sanitize_title_with_dashes($field)] = sanitize_text_field($_REQUEST['pry_global_'.sanitize_title_with_dashes($field)]);
                }
            }
        }
    }
    if ($enable_per_product) {
      $customizable_fields = wc_get_product_terms( $product_id, 'pa_customizable-fields', array( 'fields' => 'names' ) );
      foreach ($customizable_fields as $key => $field) {
        if(isset($_REQUEST['pry_'.sanitize_title_with_dashes($field)]))
        {
          $cart_item_data['pry_'.sanitize_title_with_dashes($field)] = sanitize_text_field($_REQUEST['pry_'.sanitize_title_with_dashes($field)]);
            }

        }
    }
    return $cart_item_data;
}



/**
 * Display information as Meta on Cart page
 * @param  [type] $item_data [description]
 * @param  [type] $cart_item [description]
 * @return [type]            [description]
 */
function pry_add_item_meta($item_data, $cart_item)
{
  global $print_yourself_options;
  $enable_per_product = $print_yourself_options['enable_per_product'];
  //$enable_global = $print_yourself_options['enable_global'];
  $enable_global = isset($print_yourself_options['enable_global']) ? $print_yourself_options['enable_global'] : false;
  if ($enable_global){
    for ($i=1; $i < 4; $i++) { 
      if($print_yourself_options['global_field_'.$i]) {
        $field = $print_yourself_options['global_field_'.$i];
        if(array_key_exists('pry_global_'.sanitize_title_with_dashes($field), $cart_item))
        {
          $custom_details = $cart_item['pry_global_'.sanitize_title_with_dashes($field)];
          $item_data[] = array(
            'key'   => $field,
            'value' => $custom_details
                    );
                }
            }
        }
    }

    if ($enable_per_product) {
      $product_id = $cart_item['product_id'];
      $customizable_fields = wc_get_product_terms( $product_id, 'pa_customizable-fields', array( 'fields' => 'names' ) );
      foreach ($customizable_fields as $key => $field) {
        if(array_key_exists('pry_'.sanitize_title_with_dashes($field), $cart_item))
        {
          $custom_details = $cart_item['pry_'.sanitize_title_with_dashes($field)];
          $item_data[] = array(
            'key'   => $field,
            'value' => $custom_details
                );
            }
        }
    }
    return $item_data;
}


function pry_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order)
{
  $product_id = $item->get_product_id();
  $customizable_fields = wc_get_product_terms( $product_id, 'pa_customizable-fields', array( 'fields' => 'names' ) );
  foreach ($customizable_fields as $key => $field) {
    if(array_key_exists('pry_'.sanitize_title_with_dashes($field), $values))
    {
      $item->add_meta_data('_pry_'.sanitize_title_with_dashes($field),$values['pry_'.sanitize_title_with_dashes($field)]);
        }
    }
    global $print_yourself_options;
    //$enable_global = $print_yourself_options['enable_global'];
    $enable_global = isset($print_yourself_options['enable_global']) ? $print_yourself_options['enable_global'] : false;
    if ($enable_global){
      for ($i=1; $i < 4; $i++) { 
        if($print_yourself_options['global_field_'.$i]) {
          $field = $print_yourself_options['global_field_'.$i];
          if(array_key_exists('pry_global_'.sanitize_title_with_dashes($field), $values)){
            $item->add_meta_data('_pry_global_'.sanitize_title_with_dashes($field),$values['pry_global_'.sanitize_title_with_dashes($field)]);
                }
            }
        }
    }

}
