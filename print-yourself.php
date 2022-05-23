<?php
/**
 * Plugin Name: Print yourself
 * Plugin URI: #
 * Description: Woocommerce personalized products solution
 * Version: 2.2.0
 * Author: Tan Le
 * Author URI: #
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Define constants
define('PRY_VERSION', '2.2.0');
define('PRY_POST_TYPE', 'pry_pl_form');
define('PRY_PRODUCT_META_KEY', '_pry_product_meta');
define('PRY_FORM_META_KEY', '_pry_fb-editor-data');
define('PRY_FILE', __FILE__);
define('PRY_CART_ITEM_KEY', 'pry_data');
define('PRY_CART_ITEM_PREFIX', '_pry_cf-');
define('PRY_ORDER_META_KEY', '_pry_order_meta_data');


require_once('includes/helpers.php');

if(!function_exists('pry_autoloader')){
  function pry_autoloader($class_name){
    if(0 === strpos($class_name, 'PRY')){
      $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
      $class_file = 'class-'. str_replace('_', '-', strtolower($class_name)) . '.php';
      require_once($classes_dir . $class_file);
    }
  }
}
if(!function_exists('PRY')){
  function PYR(){
    $instance = PRY_Backend::instance(__FILE__, PRY_VERSION);
    return $instance;
  }
}
spl_autoload_register('pry_autoloader');
if(is_admin()){
  PYR();
}
new PRY_Front_End(__FILE__, PRY_VERSION);
