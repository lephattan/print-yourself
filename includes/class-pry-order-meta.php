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

}
