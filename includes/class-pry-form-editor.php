<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Form_Editor
{
    /**
     * The single instance of Custom product options.
     * @var 	object
     * @access  private
     * @since 	1.0.0
     */
    private static $_instance = null;

    /**
     * The main plugin object.
     * @var 	object
     * @access  public
     * @since 	1.0.0
     */
    public $parent = null;
    private $settings = array();

    public function __construct()
    {
      add_action("add_meta_boxes", array($this, 'add_custom_meta_box'));
      add_action("save_post", array($this, 'cd_meta_box_save'));
    }

    public function add_custom_meta_box(){
      add_meta_box('pry_form_builder_box', __('Personalize Form', 'pry-text-domain'), array($this, 'meta_box_markup'), PRY_POST_TYPE, 'normal', 'high', null);
    }

    public function cd_meta_box_save($post_id){
      //error_log(print_r($_POST, true));
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
          return;
      // if our nonce isn't there, or we can't verify it, bail
      // TODO: Fix this
      //if (!isset($_POST['pry_box_nonce']) || !wp_verify_nonce($_POST['pry_box_nonce'], 'pry_meta_box_nonce'))
          //error_log('No Nonce');
          //return;
      // if our current user can't edit this post, bail
      if (!current_user_can('edit_post', $post_id))
          return;
      // now we can actually save the data
      $allowed = array(
          'a' => array(// on allow a tags
              'href' => true, // and those anchors can only have href attribute
              'target' => true,
              'class' => true,// and those anchors can only have href attribute
              'style' => true
          ),
          'b' => array('style' => true, 'class' => true),
          'strong' => array('style' => true, 'class' => true),
          'i' => array('style' => true, 'class' => true),
          'img' => array('style' => true, 'class' => true, 'src' => true),
          'span' => array('style' => true, 'class' => true),
          'p'=>array('style' => true, 'class' => true)
      );

      if (isset($_POST['pry_fb-editor-json'])) {
        $fb_data = json_decode(wp_unslash($_POST['pry_fb-editor-json']));
        // Do the json sanitizing here
        $fb_data_json = wp_slash(json_encode($fb_data));
        update_post_meta($post_id, PRY_FORM_META_KEY, $fb_data_json);
      }
      
    }

    public function meta_box_markup($object){
      PRY_Backend::view('form-edit', ['object' => $object]);
    }

    public static function instance($file = '', $version = '1.0.0') {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }
        return self::$_instance;
    }

}
