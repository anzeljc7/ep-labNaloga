<?php

require_once("model/BookDB.php");
require_once("ViewHelper.php");
require_once("forms/BooksForm.php");

class UsersController {

    public static function myAccount() {
        //TODO PREVERI ZA KATERI TIP UPORABNIKA GRE IN NASTAVI USTREZNO FORMO 
        $editForm = new CustomerSelfEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $formData = $editForm->getValue();

                $allowedKeys    = ['user_id', 'postal_code', 'name', 'surname', 'email', 'street', 'house_number'];
                $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));

                UserDB::update($userEditParams);
                ViewHelper::redirect(BASE_URL . "myAccount");
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "title" => "Your account",
                    "form" => $editForm,
                    "details" => false
                ]);
            }
        } else {

            $user = UserDB::get(['item_id' => 1]);

            $dataSource = new HTML_QuickForm2_DataSource_Array($user);
            $editForm->addDataSource($dataSource);

            echo ViewHelper::render("view/users/user-details.php", [
                "title" => "Your account",
                "form" => $editForm,
                "details" => false
            ]);
        }
    }

    public static function customersList() {
        $inputParams["type_id"] = TYPE_CUSTOMER;
        $inputParams["user_id"] = 1;

        echo ViewHelper::render("view/users/user-list.php", [
            "users" => UserDB::getByType($inputParams),
            "title" => "List of customers",
            "type" => "customers"
        ]);
    }

}
