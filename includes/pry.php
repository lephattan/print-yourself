<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$print_yourself_options = get_option( 'pry_setting' );
if ($print_yourself_options['enable_plugin']) {
  add_action('woocommerce_before_add_to_cart_button', 'pry_product_main');
  add_action('wp_enqueue_scripts', 'pry_enqueue_product_scripts');
}

function pry_enqueue_product_scripts(){
  if(is_product()){
    wp_enqueue_script('pry-product', plugin_dir_url( __FILE__ ).'../assets/js/product.js', array(), false, true);
  }
}
function pry_product_main(){
  echo '<div id="pry"></div>';
}
