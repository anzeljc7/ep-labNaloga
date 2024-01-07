<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class SellersController {

    public static function index() {
        $inputParams["type_id"] = TYPE_SELLER;
        $inputParams["user_id"] = 1;

        echo ViewHelper::render("view/users/user-list.php", [
            "users" => UserDB::getByType($inputParams),
            "title" => "List of sellers",
            "type" => "sellers"
        ]);
    }

    public static function addSeller() {
        $form = new SellerAddForm("add_form");

        if ($form->validate()) {
            $formData = $form->getValue();

            $allowedKeys      = ['name', 'surname', 'email'];
            $userInsertParams = array_intersect_key($formData, array_flip($allowedKeys));

            $existingUsers = UserDB::getByEmail(['email' => $userInsertParams['email']]);
            if (isset($existingUsers) && count($existingUsers) > 0) {
                echo ViewHelper::render("view/users/user-details.php", [
                    "title" => "Add seller",
                    "form" => $form,
                    "details" => false,
                    "type" => "sellers",
                    "error" => "User with same email already exists"
                ]);
            } else {
                $userInsertParams['hash']    = password_hash($formData['password'], PASSWORD_DEFAULT);
                $userInsertParams['type_id'] = TYPE_SELLER;
                $userInsertParams['active']  = 1;

                UserDB::insertSellerAdmin($userInsertParams);
                ViewHelper::redirect(BASE_URL . "sellers");
            }
        } else {
            echo ViewHelper::render("view/users/user-details.php", [
                "title" => "Add seller",
                "form" => $form,
                "details" => false,
                "type" => "sellers"
            ]);
        }
    }

    public static function editSeller() {
        $editForm = new SellerEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            $formData = $editForm->getValue();

            if ($editForm->validate()) {
                $allowedKeys    = ['user_id', 'name', 'surname', 'email'];
                $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));

                $existingUsers = UserDB::getByEmail(['email' => $userEditParams['email']]);
                if (isset($existingUsers) && count($existingUsers) > 0 && $existingUsers[0]['user_id'] != $userEditParams['user_id']) {
                    echo ViewHelper::render("view/users/user-details.php", [
                        "title" => "Add seller",
                        "user" => UserDB::get(['user_id' => $formData['user_id']]),
                        "form" => $editForm,
                        "details" => true,
                        "type" => "sellers",
                        "error" => "User with same email already exists"
                    ]);
                } else {
                    UserDB::updateSellerAdmin($userEditParams);
                    ViewHelper::redirect(BASE_URL . "sellers/edit?id=" . $userEditParams["user_id"]);
                }
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "user" => UserDB::get(['user_id' => $formData['user_id']]),
                    "title" => "Edit seller",
                    "form" => $editForm,
                    "details" => true,
                    "type" => "sellers"
                ]);
            }
        } else {
            $rules = [
                "id" => [
                    'filter' => FILTER_VALIDATE_INT,
                    'options' => ['min_range' => 1]
                ]
            ];

            $data = filter_input_array(INPUT_GET, $rules);

            if ($data !== null && isset($data["id"])) {
                $user = UserDB::get(['user_id' => $data["id"]]);

                $dataSource = new HTML_QuickForm2_DataSource_Array($user);
                $editForm->addDataSource($dataSource);

                echo ViewHelper::render("view/users/user-details.php", [
                    "title" => "Edit seller",
                    "user" => $user,
                    "form" => $editForm,
                    "details" => true,
                    "type" => "sellers"
                ]);
            }
        }
    }

    public static function activate() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        if ($data !== null && isset($data["id"])) {
            $inputParameters['user_id'] = $data["id"];
            $inputParameters['active']  = 1;
            UserDB::activateDeactivate($inputParameters);
        }

        ViewHelper::redirect(BASE_URL . "sellers");
    }

    public static function deactivate() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        if ($data !== null && isset($data["id"])) {
            $inputParameters['user_id'] = $data["id"];
            $inputParameters['active']  = 0;
            UserDB::activateDeactivate($inputParameters);
        }

        ViewHelper::redirect(BASE_URL . "sellers");
    }
}
