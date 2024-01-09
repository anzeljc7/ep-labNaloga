<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class CustomersController {

    public static function index() {
        $inputParams["type_id"] = TYPE_CUSTOMER;
        $inputParams["user_id"] = 1;

        echo ViewHelper::render("view/users/user-list.php", [
            "users" => UserDB::getByType($inputParams),
            "title" => "List of customers",
            "type" => "customers"
        ]);
    }

    public static function addCustomer() {
        $form = new CustomerAddForm("add_form");

        if ($form->validate()) {
            $formData = $form->getValue();

            $allowedKeys      = ['postal_code', 'name', 'surname', 'email', 'street', 'house_number'];
            $itemInsertParams = array_intersect_key($formData, array_flip($allowedKeys));

            $existingUsers = UserDB::getByEmail(['email' => $itemInsertParams['email']]);
            if (isset($existingUsers) && count($existingUsers) > 1) {
                echo ViewHelper::render("view/users/user-details.php", [
                    "title" => "Add customer",
                    "form" => $form,
                    "details" => false,
                    "type" => "sellers",
                    "error" => "User with same email already exists"
                ]);

            } else {
                $itemInsertParams['hash']    = password_hash($formData['password'], PASSWORD_DEFAULT);
                $itemInsertParams['type_id'] = TYPE_CUSTOMER;
                $itemInsertParams['active']  = 1;

                UserDB::insert($itemInsertParams);
                ViewHelper::redirect(BASE_URL . "customers");
            }
        } else {
            echo ViewHelper::render("view/users/user-details.php", [
                    "title" => "Add customer",
                    "form" => $form,
                    "details" => false,
                    "type" => "sellers",
                ]);
        }
    }

    public static function editCustomer() {
        $editForm = new CustomerEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            $formData = $editForm->getValue();

            if ($editForm->validate()) {

                $allowedKeys    = ['user_id', 'postal_code', 'name', 'surname', 'email', 'street', 'house_number'];
                $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));

                $existingUsers = UserDB::getByEmail(['email' => $userEditParams['email']]);
                if (isset($existingUsers) && count($existingUsers) > 0 && $existingUsers[0]['user_id'] != $userEditParams['user_id']) {
                    echo ViewHelper::render("view/users/user-details.php", [
                        "user" => UserDB::get(['user_id' => $userEditParams['user_id']]),
                        "title" => "Customer details",
                        "form" => $editForm,
                        "details" => true,
                        "type" => "customers",
                        "error" => "User with same email already exists"
                    ]);
                } else {
                    UserDB::updateCustomer($userEditParams);
                    ViewHelper::redirect(BASE_URL . "customers");
                }
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "user" => UserDB::get(['user_id' => $userEditParams['user_id']]),
                    "title" => "Customer details",
                    "form" => $editForm,
                    "details" => true,
                    "type" => "customers"
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
                    "user" => $user,
                    "title" => "Customer details",
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

        ViewHelper::redirect(BASE_URL . "customers");
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

        ViewHelper::redirect(BASE_URL . "customers");
    }
}
