<?php

require_once("model/BookDB.php");
require_once("model/AuthDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class UsersController {

    public static function myAccount() {
        //TODO PREVERI ZA KATERI TIP UPORABNIKA GRE IN NASTAVI USTREZNO FORMO 
        $curUser      = AuthDB::getFullCurrentUser();
        $currUserType = $curUser['type_id'];

        $editForm = null;
        $redirect = "";
        if ($currUserType == TYPE_ADMIN) {
            $editForm = new SellerAdminSelfEditForm("edit_form");
            $redirect = "sellers";
        } else if ($currUserType == TYPE_SELLER) {
            $editForm = new SellerAdminSelfEditForm("edit_form");
            $redirect = "items";
        } else if ($currUserType == TYPE_CUSTOMER) {
            $editForm = new CustomerSelfEditForm("edit_form");
            $redirect = "shop";
        }

        if ($editForm->isSubmitted()) {
            $formData = $editForm->getValue();

            if ($editForm->validate()) {

                $existingUsers = UserDB::getByEmail(['email' => $curUser['email']]);
                if (isset($existingUsers) && count($existingUsers) > 0 && $existingUsers[0]['user_id'] != $formData['user_id']) {
                    echo ViewHelper::render("view/users/user-details.php", [
                        "user" => $curUser,
                        "title" => "Your account",
                        "form" => $editForm,
                        "details" => false,
                        "type" => $redirect,
                        "error" => "User with same email already exists"
                    ]);
                } else {
                    $result = password_verify($formData['password'], $existingUsers[0]['hash']);

                    if ($result) {
                        if ($currUserType == TYPE_CUSTOMER) {
                            self::editCustomer($formData, $existingUsers[0]['hash']);
                        } else {
                            self::editSellerAdmin($formData, $existingUsers[0]['hash']);
                        }
                        ViewHelper::redirect(BASE_URL . "myAccount");
                    } else {
                        echo ViewHelper::render("view/users/user-details.php", [
                            "user" => $curUser,
                            "title" => "Your account",
                            "form" => $editForm,
                            "details" => false,
                            "type" => $redirect,
                            "error" => "You entered wrong password"
                        ]);
                    }
                }
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "user" => $curUser,
                    "title" => "Your account",
                    "form" => $editForm,
                    "details" => false,
                    "type" => $redirect
                ]);
            }
        } else {
            $dataSource = new HTML_QuickForm2_DataSource_Array($curUser);
            $editForm->addDataSource($dataSource);

            echo ViewHelper::render("view/users/user-details.php", [
                "user" => $curUser,
                "title" => "Your account",
                "form" => $editForm,
                "details" => false,
                "type" => $redirect
            ]);
        }
    }

    private static function editCustomer(array $formDatam, string $hash) {
        $allowedKeys    = ['user_id', 'postal_code', 'name', 'surname', 'email', 'street', 'house_number'];
        $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));
        if (isset($formData['newPassword'])) {
            $userEditParams['hash'] = password_hash($formData['newPassword'], PASSWORD_DEFAULT);
        } else {
            $userEditParams['hash'] = $hash;
        }
        UserDB::update($userEditParams);
    }

    private static function editSellerAdmin(array $formData, string $hash) {

        $allowedKeys    = ['name', 'surname', 'email', 'user_id'];
        $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));
        if (isset($formData['newPassword'])) {
            $userEditParams['hash'] = password_hash($formData['newPassword'], PASSWORD_DEFAULT);
        } else {
            $userEditParams['hash'] = $hash;
        }
        UserDB::updateSelftSellerAdmin($userEditParams);
    }
}
