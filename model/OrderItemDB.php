<?php

require_once 'model/AbstractDB.php';

class OrderItemDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO OrderItem (order_id, item_id, quantity) "
                        . " VALUES (:order_id, :item_id, :quantity)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE OrderItem SET quantity = :quantity"
                        . " WHERE order_id = :order_id and item_id = :item_id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM OrderItem WHERE order_id = :order_id", $id);
    }

    public static function get(array $id) {
        $items = parent::query("SELECT order_id, item_id, quantity"
                        . " FROM OrderItem"
                        . " WHERE order_id = :order_id", $id);
        
        if (count($items) == 1) {
            return $items[0];
        } else {
            throw new InvalidArgumentException("No such item");
        }
    }

    public static function getAll() {
        return parent::query("SELECT order_id, item_id, quantity"
                        . " FROM OrderItem"
                        . " ORDER BY order_id, item_id  ASC");
    }
    
    
    public static function getByOrderId(array $params) {
        return parent::query("SELECT order_id, item_id, quantity"
                        . " FROM OrderItem"
                        . " WHERE order_id = :order_id"
                        . " ORDER BY order_id  ASC", $params);
    }
}
