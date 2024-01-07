<?php

require_once("model/UserDB.php");

class AuthDb {

    public static function addCurentUser(int $userId) {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);

            return false;
        }

        $user                     = UserDB::get(['user_id' => $userId]);
        $_SESSION["user"]["user_id"]   = $user['user_id'];
        $_SESSION["user"]["type_id"] = $user['type_id'];
        return true;
    }

    public static function checkCurrentUserEmail(string $email) {
        $user = UserDB::get(['user_id' => $_SESSION["user"]["user_id"]]);
        if ($user && $user['email'] == $email) {
            return true;
        }

        return false;
    }
    
    public static function getCurrentUserType(){
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["type_id"])){
            return $_SESSION["user"]["type_id"];
        }
        return null;
    }
    
    public static function getCurrentUser() {
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["user_id"]) && isset($_SESSION["user"]["type_id"])) {
            return $_SESSION["user"];
        }
        return null;
    }
    
     public static function getFullCurrentUser() {
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["user_id"]) && isset($_SESSION["user"]["type_id"])) {
            return UserDB::get(['user_id' => $_SESSION["user"]["user_id"]]);
        }
        return null;
    }

    public static function logout() {
        unset($_SESSION["user"]);
    }
}
