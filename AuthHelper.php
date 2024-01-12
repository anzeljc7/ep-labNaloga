<?php

require_once("model/AuthDB.php");
require_once("model/UserDB.php");

class AuthHelper {

    public static function checkUserRole(array $allowedRoles) {
        $currUser = AuthDB::getCurrentUser();

        if (!isset($currUser)) {
            ViewHelper::redirect(BASE_URL . "login");
            return false;
        } else {
            $currUserRole = $currUser['type_id'];

            if (!in_array($currUserRole, $allowedRoles)) {
                self::makeRedirect($currUserRole);
                return false;
            }
        }
        return true;
    }

    private static function makeRedirect(int $role) {
        if ($role == TYPE_ADMIN) {
            ViewHelper::redirect(BASE_URL . "sellers");
        } else if ($role == TYPE_SELLER) {
            ViewHelper::redirect(BASE_URL . "ordersPending");
        } else if ($role == TYPE_CUSTOMER) {
            ViewHelper::redirect(BASE_URL . "shop");
        } else {
            ViewHelper::redirect(BASE_URL . "login");
        }
    }

    public static function checkForCertificate(int $id) {
        $user = UserDB::get(['user_id' => $id]);

        if (!$user) {
            ViewHelper::redirect(BASE_URL . "login");
            return false;
        } else {
            $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

            if ($user['type_id'] == TYPE_CUSTOMER) {
                AuthDB::addCurentUser($user['user_id']);
                ViewHelper::redirect(BASE_URL . "shop");
                return true;
            }

            if ($client_cert != null) {
                $cert_data = openssl_x509_parse($client_cert);
                $certEmail = $cert_data['subject']['emailAddress'];

                if ($certEmail == $user['email'] && $user['type_id'] == TYPE_ADMIN) {
                    AuthDB::addCurentUser($user['user_id']);
                    ViewHelper::redirect(BASE_URL . "sellers");
                    return true;
                } else if ($certEmail == $user['email'] && $user['type_id'] == TYPE_SELLER) {
                    AuthDB::addCurentUser($user['user_id']);
                    ViewHelper::redirect(BASE_URL . "ordersPending");
                    return true;
                } else {
                    ViewHelper::redirect(BASE_URL . "login");
                    return false;
                }
            } else {
                AuthDB::logout();
                ViewHelper::redirect(BASE_URL . "login");
                return false;
            }
        }
    }
}
