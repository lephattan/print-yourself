<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Backend extends PRY_Order_Meta
{

  /**
   * @var    object
   * @access  private
   * @since    1.0.0
   */
  private static $_instance = null;

  /**
   * The version number.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $_version;

  /**
   * The token.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $_token;

  /**
   * The main plugin file.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $file;

  /**
   * The main plugin directory.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $dir;

  /**
   * The plugin assets directory.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $assets_dir;

  /**
   * The plugin assets URL.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $assets_url;

  /**
   * Constructor function.
   * @access  public
   * @since   1.0.0
   * @return  void
   */
  public function __construct($file = '', $version = '1.0.0')
  {
    $this->_version = $version;
    $this->file = $file;
    $this->dir = dirname($this->file);

    add_filter('manage_' . PRY_POST_TYPE . '_posts_columns', array($this, 'manage_form_columns'), 20, 1);
    add_action('manage_' . PRY_POST_TYPE . '_posts_custom_column', array($this, 'manage_form_column'), 10, 2);

    add_filter("manage_taxonomies_for_" . PRY_POST_TYPE . "_columns", array($this, 'manage_taxonomies_for_list'), 10, 2);

    PRY_Form_Editor::instance();
    }

    static function view($view, $data = array())
    {
      extract($data);
      include(plugin_dir_path(__FILE__) . 'views/' . $view . '.php');
    }

    public function manage_form_columns($columns)
    {
      return $columns;
    }

    public function manage_form_column($column_name, $post_id)
    {
      if ($column_name == 'pry_products') {
        $args = array(
          'post_type' => 'product',
          'meta_query' => array(
            array(
              'key' => PRY_PRODUCT_META_KEY,
              'value' => 'i:' . $post_id . ';',
              'compare' => 'LIKE',
                )
            )
        );
        $prolist = get_posts($args);
        $link = '';
        if (is_array($prolist)) {
          foreach ($prolist as $v) {
            $link .= '<a href="' . get_edit_post_link($v) . '">' . get_the_title($v) . '</a>, ';
            }
        }
        echo trim($link, ', ');
      }
    }

    public function manage_taxonomies_for_list($tax, $post_type)
    {
        $taxonomies = get_object_taxonomies($post_type, 'object');
        $taxonomies = wp_filter_object_list($taxonomies, array(), 'and', 'name');
        return $taxonomies;
    }

    /**
     * @since 1.0.0
     * @static
     * @see WordPress_Plugin_Template()
     * @return Main WCPA instance
     */
    public static function instance($file = '', $version = '1.0.0')
    {
      if (is_null(self::$_instance)) {
        self::$_instance = new self($file, $version);
        }
        return self::$_instance;
    }
    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
      _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
      _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->_version);
    }
}
