<?php

require_once("model/AuthDB.php");

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
    
    public static function checkForCertificate($userEmail){
        $authorized_users = ["Ana"];
        
        # preberemo odjemačev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");
        $commonname = null;
        
        if($client_cert !=null){
            # in ga razčlenemo
            $cert_data = openssl_x509_parse($client_cert);
        
            # preberemo ime uporabnika (polje "common name")
            $commonname = $cert_data['subject']['CN'];
        }else{
            echo "Ni podan cert";
        }
        
    }
}
