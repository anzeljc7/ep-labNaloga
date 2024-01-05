<?php

require_once 'model/AbstractDB.php';

class OrderDB extends AbstractDB {

    public static function insert(array $params) {
        return parent::modify("INSERT INTO UserOrder (user_id, status_id, order_date, total) "
                        . " VALUES (:user_id, :status_id, :order_date, :total)", $params);
    }

    public static function update(array $params) {
        return parent::modify("UPDATE UserOrder SET status_id = :status_id"
                        . " WHERE order_id = :order_id", $params);
    }

    public static function delete(array $id) {
        return parent::modify("DELETE FROM UserOrder WHERE order_id = :order_id", $id);
    }

    public static function get(array $id) {
        $items = parent::query("SELECT order_id, user_id, status_id, order_date, total"
                        . " FROM UserOrder"
                        . " WHERE order_id = :order_id", $id);

        if (count($items) == 1) {
            return $items[0];
        } else {
            throw new InvalidArgumentException("No such item");
        }
    }

    public static function getAll() {
        return parent::query("SELECT order_id, user_id, status_id, order_date, total"
                        . " FROM UserOrder"
                        . " ORDER BY order_id ASC");
    }

    public static function getByStatus(array $statusId) {
        $items = parent::query("SELECT order_id, user_id, status_id, order_date, total"
                        . " FROM UserOrder"
                        . " WHERE status_id = :status_id", $statusId);

        return $items;
    }

    public static function getByUser(array $userId) {
        $items = parent::query("SELECT order_id, user_id, status_id, order_date, total"
                        . " FROM UserOrder"
                        . " WHERE user_id = :user_id", $userId);

        return $items;
    }
}
