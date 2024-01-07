<?php

require_once("model/UserDB.php");
require_once("model/AuthDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class AuthController {

    public static function login() {
        $form = new LoginForm("login_form");

        if ($form->validate()) {
            $formData = $form->getValue();

            $existingUsers = UserDB::getByEmail(['email' => $formData['email']]);

            if (isset($existingUsers) && count($existingUsers) == 1) {
                $result = password_verify($formData['password'], $existingUsers[0]['hash']);
                if ($result) {
                    if ($existingUsers[0]['type_id'] == TYPE_PENDING) {
                        echo ViewHelper::render("view/auth/login.php", [
                            "form" => $form,
                            "error" => "Please confirm your registration"
                        ]);
                    } else if (!$existingUsers[0]['active']) {
                        echo ViewHelper::render("view/auth/login.php", [
                            "form" => $form,
                            "error" => "Your account is deactivated"
                        ]);
                    } else {

                        AuthDB::addCurentUser($existingUsers[0]['user_id']);
                        $currUserType = AuthDB::getCurrentUserType();

                        if ($currUserType == TYPE_ADMIN) {
                            ViewHelper::redirect(BASE_URL . "sellers");
                        } else if ($currUserType == TYPE_CUSTOMER) {
                            ViewHelper::redirect(BASE_URL . "shop");
                        } else if($currUserType == TYPE_SELLER) {
                            ViewHelper::redirect(BASE_URL . "items");
                        }
                    }
                }
            }
            echo ViewHelper::render("view/auth/login.php", [
                "form" => $form,
                "error" => "Email or password not correct"
            ]);
        } else {
            echo ViewHelper::render("view/auth/login.php", [
                "form" => $form
            ]);
        }
    }

    public static function register() {
        $form = new RegisterForm("register_form");

        if ($form->validate()) {
            $formData         = $form->getValue();
            $allowedKeys      = ['postal_code', 'name', 'surname', 'email', 'street', 'house_number'];
            $itemInsertParams = array_intersect_key($formData, array_flip($allowedKeys));

            $existingUsers = UserDB::getByEmail(['email' => $itemInsertParams['email']]);
            if (isset($existingUsers) && count($existingUsers) > 0) {
                echo ViewHelper::render("view/auth/register.php", [
                    "form" => $form,
                    "error" => "User with provided email already exists",
                    "title" => "Register"
                ]);
            } else {
                $itemInsertParams['hash']    = password_hash($formData['password'], PASSWORD_DEFAULT);
                $itemInsertParams['type_id'] = TYPE_CUSTOMER;
                $itemInsertParams['active']  = 1;

                UserDB::insert($itemInsertParams);
                ViewHelper::redirect(BASE_URL . "login");
            }
        } else {
            echo ViewHelper::render("view/auth/register.php", [
                "form" => $form,
                "title" => "Register"
            ]);
        }
    }

    public static function logout() {
        AuthDB::logout();
        ViewHelper::redirect(BASE_URL . "login");
    }

    public static function confirmRegistration() {
        
    }
}
