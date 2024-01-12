<?php

require_once 'model/AbstractDB.php';

class ItemDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO Item (item_name, price, active, description) "
                        . " VALUES (:item_name, :price, :active, :description)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE Item SET item_name = :item_name, price = :price, "
                        . "description = :description"
                        . " WHERE item_id = :item_id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM book WHERE id = :id", $id);
    }

    public static function get(array $id) {
        $items = parent::query("SELECT item_id, item_name, price, active, description"
                        . " FROM Item"
                        . " WHERE item_id = :item_id", $id);
        
        if (count($items) == 1) {
            return $items[0];
        } else {
            throw new InvalidArgumentException("No such item");
        }
    }

    public static function getAll() {
        return parent::query("SELECT item_id, item_name, price, active, description"
                        . " FROM Item"
                        . " ORDER BY item_id ASC");
    }
    
    public static function activateDeactivate(array $params) {
        return parent::modify("UPDATE Item SET active = :active"
                            . " WHERE item_id = :item_id", $params);
    }
    
    
    public static function getAllActive() {
        return parent::query("SELECT item_id, item_name, price, description"
                        . " FROM Item"
                        . " WHERE active = 1"
                        . " ORDER BY item_id ASC");
    }

}
