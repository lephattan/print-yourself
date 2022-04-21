<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Front_End extends PRY_Order_Meta 
{
  /**
   * The version number.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $_version; 
  /**
   * The main plugin file.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $file;
  function __construct($file='', $version) {
    $this->$file = $file; 
    $this->_version = $version;
    add_action('init', array($this, 'register_type_forms'));
  }
    /**
     *    Create post type forms
     */
    public function register_type_forms()
    {
      $post_type = PRY_POST_TYPE;
      $labels = array(
        'name' => __('Personalize Form', 'pry-text-domain'),
        'singular_name' => __('Personalize Form', 'pry-text-domain'),
        'name_admin_bar' => 'PRY_Form',
        'add_new' => _x('Add New Form', $post_type, 'pry-text-domain'),
        'add_new_item' => sprintf(__('Add New %s', 'pry-text-domain'), 'Personalize Form'),
        'edit_item' => sprintf(__('Edit %s', 'pry-text-domain'), 'Personalize Form'),
        'new_item' => sprintf(__('New %s', 'pry-text-domain'), 'Personalize Form'),
        'all_items' => sprintf(__('Personalize Forms', 'pry-text-domain'), 'Personalize Form'),
        'view_item' => sprintf(__('View %s', 'pry-text-domain'), 'Personalize Form'),
        'search_items' => sprintf(__('Search %s', 'pry-text-domain'), 'Personalize Form'),
        'not_found' => sprintf(__('No %s Found', 'pry-text-domain'), 'Personalize Form'),
        'not_found_in_trash' => sprintf(__('No %s Found In Trash', 'pry-text-domain'), 'Personalize Form'),
        'parent_item_colon' => sprintf(__('Parent %s'), 'Personalize Form'),
        'menu_name' => 'Personalize Product Options'
      );
      $args = array(
        'labels' => apply_filters($post_type . '_labels', $labels),
        'description' => '',
        'public' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=product',
        'show_in_nav_menus' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'rest_base' => $post_type,
        'hierarchical' => false,
        'show_in_rest' => false,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'supports' => array('title'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-post',
        'taxonomies' => array()
        );

      register_post_type($post_type, apply_filters($post_type . '_register_args', $args, $post_type));

      if (is_admin()) {
        register_taxonomy_for_object_type('product_cat', $post_type);
        }
    }
}
