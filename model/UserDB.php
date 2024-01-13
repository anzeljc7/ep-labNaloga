<?php

require_once 'model/AbstractDB.php';

class UserDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO StoreUser (postal_code, type_id, name, surname, email, hash, street, house_number, active)"
                        . " VALUES (:postal_code, :type_id, :name, :surname, :email, :hash, :street, :house_number, :active)", $params);
    }
    
    public static function insertSellerAdmin(array $params) {
        return parent::modify("INSERT INTO StoreUser (type_id, name, surname, email, hash, active)"
                        . " VALUES (:type_id, :name, :surname, :email, :hash, :active)", $params);
    }
    
    public static function update(array $params) {
        return parent::modify("UPDATE StoreUser SET postal_code = :postal_code, name = :name, "
                        . "surname = :surname, email = :email, street = :street, house_number = :house_number, hash = :hash"
                        . " WHERE user_id = :user_id", $params);
    }
    
     public static function updateSelftSellerAdmin(array $params) {
        return parent::modify("UPDATE StoreUser SET name = :name, hash = :hash, "
                        . "surname = :surname, email = :email"
                        . " WHERE user_id = :user_id", $params);
    }
    
    public static function updateCustomer(array $params) {
        return parent::modify("UPDATE StoreUser SET postal_code = :postal_code, name = :name, "
                        . "surname = :surname, email = :email, street = :street, house_number = :house_number"
                        . " WHERE user_id = :user_id", $params);
    }

    public static function updateSellerAdmin(array $params) {
        return parent::modify("UPDATE StoreUser SET name = :name, "
                        . "surname = :surname, email = :email"
                        . " WHERE user_id = :user_id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM StoreUser WHERE user_id = :user_id", $id);
    }

    public static function get(array $id) {
        $users = parent::query("SELECT user_id, postal_code, type_id, name, surname, email, hash, street, house_number, active"
                        . " FROM StoreUser"
                        . " WHERE user_id = :user_id", $id);

        if (count($users) == 1) {
            return $users[0];
        } else {
            throw new InvalidArgumentException("No such user");
        }
    }

    public static function getAll() {
        return parent::query("SELECT user_id, postal_code, type_id, name, surname, email, hash, street, house_number, active"
                        . " FROM StoreUser"
                        . " ORDER BY user_id ASC");
    }

    public static function getByType(array $params) {
        return parent::query("SELECT user_id, postal_code, type_id, name, surname, email, hash, street, house_number, active"
                        . " FROM StoreUser"
                        . " WHERE type_id = :type_id and user_id != :user_id"
                        . " ORDER BY user_id ASC", $params);
    }

    public static function getByEmail(array $email) {
        return parent::query("SELECT user_id, postal_code, type_id, name, surname, email, hash, street, house_number, active"
                        . " FROM StoreUser"
                        . " WHERE email = :email"
                        . " ORDER BY user_id ASC", $email);
    }

    public static function activateDeactivate(array $params) {
        return parent::modify("UPDATE StoreUser SET active = :active"
                        . " WHERE user_id = :user_id", $params);
    }
}
