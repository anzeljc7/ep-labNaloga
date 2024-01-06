<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class SellersController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);
        if ($data !== null && isset($data["id"])) {
            self::editSeller();
        } else {
            $inputParams["type_id"] = TYPE_SELLER;
            $inputParams["user_id"] = 1;

            echo ViewHelper::render("view/users/user-list.php", [
                "users" => UserDB::getByType($inputParams),
                "title" => "List of sellers",
                "type" => "sellers"
            ]);
        }
    }

    public static function addSeller() {
        $form = new SellerAddForm("add_form");

        if ($form->validate()) {
            $formData = $form->getValue();

            $allowedKeys      = ['name', 'surname', 'email'];
            $itemInsertParams = array_intersect_key($formData, array_flip($allowedKeys));

            $existingUsers = UserDB::getByEmail(['email' => $itemInsertParams['email']]);
            if (isset($existingUsers) && count($existingUsers) > 0) {
                
            } else {
                $itemInsertParams['hash']         = password_hash($formData['password'], PASSWORD_DEFAULT);
                $itemInsertParams['type_id']      = TYPE_CUSTOMER;
                $itemInsertParams['active']       = 1;
                $itemInsertParams['postal_code']  = null;
                $itemInsertParams['house_number'] = null;
                $itemInsertParams['street']       = null;

                UserDB::insert($itemInsertParams);
                ViewHelper::redirect(BASE_URL . "customers");
            }
        } else {
            echo ViewHelper::render("view/users/user-details.php", [
                "title" => "Add seller",
                "form" => $form,
                "details" => false,
                "type" => "customers"
            ]);
        }
    }

    public static function editSeller() {
        $editForm = new SellerEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            $formData = $editForm->getValue();

            if ($editForm->validate()) {

                $allowedKeys                    = ['user_id', 'name', 'surname', 'email', 'active'];
                $userEditParams                 = array_intersect_key($formData, array_flip($allowedKeys));
                $userEditParams['house_number'] = null;
                $userEditParams['street']       = null;
                $userEditParams['postal_code']  = null;

                UserDB::update($userEditParams);
                ViewHelper::redirect(BASE_URL . "sellers/edit?id=" . $userEditParams["user_id"]);
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "user" => $formData['user_id'],
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
                    "type" => "customers"
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
