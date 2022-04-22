<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Form {
  private $data = null;
  private $product = false;

  public function __construct(){
  }

/*
 *Render form to front-end
 */
  public function get_forms_by_product($product_id=false) {
    if (($this->data === null || empty($this->data)) && $product_id) {
      $this->data = array();
      $post_ids = $this->get_form_ids($product_id);
      error_log(print_r($post_ids, true));
      foreach ($post_ids as $id) {
        if(get_post_status($id) === 'publish'){
            $json_string = get_post_meta($id, PRY_FORM_META_KEY, true);
            error_log($json_string);
            $json_encoded = json_decode($json_string);
            if ($json_encoded && is_array($json_encoded)) {
              $this->data = array_merge($this->data, $json_encoded);
            }
        }
      }
    }
  }
  public function get_form_ids($product_id){
   $post_ids = get_posts(
      array(
          'tax_query' => array(
              array(
                  'taxonomy' => 'product_cat',
                  'field' => 'ids',
                  'include_children' => false,
                  'terms' => wp_get_object_terms($product_id, 'product_cat', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids'))
              )
          ),
          'fields' => 'ids',
          'post_type' => PRY_POST_TYPE,
          'posts_per_page' => -1
      )
    );
    return $post_ids;

  }
  public function render($product_id = null) {
    if (!$this->product) {
      global $product;
      $this->product = $product;
    }
    if($this->data && !empty($this->data)){
      printf('<script> window.plData = %s</script>', json_encode($this->data));
      echo '<div id="pry"></div>';
      printf('<script src="%s" defer="true"></script>', plugin_dir_url(PRY_FILE).'assets/js/product.js');
    }
  }

}

