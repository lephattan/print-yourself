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
  /**
   * The single instance of WordPress_Plugin_Template_Settings.
   * @var    object
   * @access  private
   * @since    1.0.0
   */
  private static $_instance = null;
  public $hooked_field_tag = false;

  function __construct($file='', $version='1.0.0') {
    $this->$file = $file; 
    $this->_version = $version;
    add_action('init', array($this, 'register_type_forms'));
    //add_action('init', array($this, 'render_init_function'));
    add_action('woocommerce_before_add_to_cart_form', array($this, 'render_init_function'));// initiate render methods after loading $product,
    add_filter('woocommerce_add_cart_item_data', array($this, 'add_cart_item_data'), 10, 3);
    add_filter('woocommerce_get_item_data', array($this, 'get_item_data'), 10, 2);
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

    public static function instance($parent)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
        }
        return self::$_instance;
    }

    public function render_init_function()
    {
      if ($this->hooked_field_tag !== false) {
            remove_action($this->hooked_field_tag[0], array($this, 'before_add_to_cart_button'), $this->hooked_field_tag[1]);
        }
      // TODO: add config to change hook later
      $this->hooked_field_tag = array('woocommerce_before_add_to_cart_button', 10);
      add_action($this->hooked_field_tag[0], array($this, 'before_add_to_cart_button'), $this->hooked_field_tag[1]);
    }
    public function before_add_to_cart_button()
    {
      global $product;
      $product_id = $product->get_id();
      $form = new PRY_Form();
      $form->get_forms_by_product($product_id);
      $form->render($product_id);
    }

    public function add_cart_item_data($cart_item_data, $product_id, $variation_id){
      $pry_data = array();
      $form = new PRY_Form();
      $form->get_forms_by_product($product_id);
      foreach ($_REQUEST as $key => $value) {
        if(0 === strpos($key, 'pry_cf-')){
          $name = str_replace('pry_cf-', '', $key );
          $cart_item_data[$key] = $value;
          $field = $form->get_field_by_name($name);
          if($field !== null) {
            $field['value'] = $value;
            $pry_data[] = $field;
          }
        }
      }
      $cart_item_data['pry_data'] = $pry_data;
      return $cart_item_data;
    }

    public function get_item_data($item_data, $cart_item){
      if(isset($cart_item['pry_data']) && !empty($cart_item['pry_data'])){
        foreach($cart_item['pry_data'] as $field){
          $item_data[] = array(
            'key' => $field['data']['label'],
            'value' => $field['value']
          );
        }
      }
      return $item_data;
    }
}
