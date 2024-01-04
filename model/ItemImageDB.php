<?php

require_once 'model/AbstractDB.php';

class ItemImageDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO ItemImage(item_id, image_path) "
                        . " VALUES(:item_id, :image_path)", $params);
    }
    
    public static function update(array $params) {        
        return self::insert($params);
    }
    
    public static function delete(array $id) {
        return parent::modify("DELETE FROM ItemImage WHERE item_id = :item_id", $id);
    }

    public static function get(array $id) {
        $items = parent::query("SELECT image_path"
                        . " FROM ItemImage"
                        . " WHERE item_id = :item_id", $id);
        
        if (count($items) == 1) {
            return $items[0];
        } else {
            throw new InvalidArgumentException("No such item");
        }
    }
    
    public static function getAll() {
        return [];
    }

}
