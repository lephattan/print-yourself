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
define('PRY_VERSION', '2.0.0');

include 'remote-update.php';

include 'option-page.php';
include 'includes/pry-main.php';
include 'includes/pry.php';
