<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
require_once("forms/UsersForm.php");

class CustomersController {

    public static function index() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);
        if ($data !== null && isset($data["id"])) {
            self::editCustomer();
        } else {
            $inputParams["type_id"] = TYPE_CUSTOMER;
            $inputParams["user_id"] = 1;

            echo ViewHelper::render("view/users/user-list.php", [
                "users" => UserDB::getByType($inputParams),
                "title" => "List of customers",
                "type" => "customers"
            ]);
        }
    }

    public static function addCustomer() {
        $form = new RegisterForm("add_form");

        if ($form->validate()) {
            $formData = $form->getValue();

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
                ViewHelper::redirect(BASE_URL . "customers");
            }
        } else {
            echo ViewHelper::render("view/auth/register.php", [
                "title" => "Add customer",
                "form" => $form
            ]);
        }
    }

    public static function editCustomer() {
        $editForm = new CustomerEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            $formData = $editForm->getValue();

            if ($editForm->validate()) {

                $allowedKeys    = ['user_id', 'postal_code', 'name', 'surname', 'email', 'street', 'house_number', 'active'];
                $userEditParams = array_intersect_key($formData, array_flip($allowedKeys));

                UserDB::update($userEditParams);
                ViewHelper::redirect(BASE_URL . "customers");
            } else {
                echo ViewHelper::render("view/users/user-details.php", [
                    "user" => $formData['user_id'],
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