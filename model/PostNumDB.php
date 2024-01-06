<?php

require_once 'model/AbstractDB.php';

class PostNumDB extends AbstractDB {

    public static function insert(array $params) {
    }

    public static function update(array $params) {
    }

    public static function delete(array $id) {
    }

    public static function get(array $id) {
        $codes =  parent::query("SELECT postal_code, city"
                        . " FROM PostalCode"
                        . " WHERE postal_code = :postal_code"
                        . " ORDER BY id ASC", $id);
        
        if (count($codes) == 1) {
            return $codes[0];
        } else {
            throw new InvalidArgumentException("No such postal code");
        }
    }

    
    public static function getAll() {
        $codes =  parent::query("SELECT postal_code, city"
                        . " FROM PostalCode"
                        . " ORDER BY postal_code ASC");
        $values = [];
         foreach ($codes as $code) {
            $values[$code["postal_code"]] = $code["postal_code"] . " - " . $code["city"];
        }
        return $values;
    }

}
