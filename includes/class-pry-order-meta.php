<?php
defined('ABSPATH') or die('No script kiddies please!');

class PRY_Order_Meta {

    /*
     * Add meta to line item when creating order
     */
    public function checkout_create_order_line_item($item, $cart_item_key, $values, $order) {
      if(empty($values[PRY_CART_ITEM_KEY])){ return;}
      //write_log(array(
        //'item' => $item,
        //'cart_item_key' => $cart_item_key,
        //'values' => $values,
      //));

      $meta_data = array();
      foreach ($values[PRY_CART_ITEM_KEY] as $value) {
        $item->add_meta_data( PRY_CART_ITEM_PREFIX.$value['name'], $value['value']);
        $meta_data[] = array_intersect_key($value, array_flip(array('name', 'label', 'value', 'type')));
      }
      $item->add_meta_data(PRY_ORDER_META_KEY, $meta_data);
    }

    public function order_processing($order_id){
      $order = wc_get_order($order_id);
      write_log($order->get_items());
    }

}
