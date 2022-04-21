<?php
/**
 * Plugin Name: Print yourself
 * Plugin URI: #
 * Description: Woocommerce personalized products solition
 * Version: 2.0.0
 * Author: Tan Le
 * Author URI: #
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Define constants
define('PRY_VERSION', '2.0.0');
define('PRY_POST_TYPE', 'pry_pl_form');


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
    return null;
  }
}
spl_autoload_register('pry_autoloader');
if(is_admin()){
  PYR();
}
new PRY_Front_End(__FILE__, PRY_VERSION);

require 'remote-update.php';
require 'option-page.php';
require 'includes/pry-main.php';
require 'includes/pry.php';
