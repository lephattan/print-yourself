<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Order_Meta {

    /*
     * Add meta to line item when creating order
     */
    public function checkout_create_order_line_item($item, $cart_item_key, $values, $order) {
      if(empty($values[PRY_CART_ITEM_KEY])){ return;}

      $meta_data = array();
      foreach ($values[PRY_CART_ITEM_KEY] as $value) {
        $item->add_meta_data( PRY_CART_ITEM_PREFIX.$value['name'], $value['value']);
        $meta_data[] = array_intersect_key($value, array_flip(array('name', 'label', 'value', 'type')));
      }
      $item->add_meta_data(PRY_ORDER_META_KEY, $meta_data);
    }


    public function display_item_meta($html, $item, $args) {
      $pry_order_meta = $item->get_meta(PRY_ORDER_META_KEY, true);
      if ($pry_order_meta){
        $strings = array();
        foreach ($pry_order_meta as $value) {
          $strings[] = $args['label_before'].wp_kses_post($value['label']).$args['label_after'].$value['value'];
        }
        if($strings){
          $html .= $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
        }
      }
      return $html;
    }
}
