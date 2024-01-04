<?php

require_once("model/ItemDB.php");
require_once("model/ItemImageDB.php");
require_once("ViewHelper.php");
require_once("forms/ItemsForm.php");

class ItemsController {

    public static function index() {

        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);
        if ($data !== null && isset($data["id"])) {
            $inputParameters['item_id'] = $data["id"];
            echo ViewHelper::render("view/items/item-detail.php", [
                "item" => ItemDB::get($inputParameters)
            ]);
        } else {
            echo ViewHelper::render("view/items/item-list.php", [
                "items" => ItemDB::getAll(),
            ]);
        }
    }

    public static function add() {
        $form = new ItemsInsertForm("add_form");

        if ($form->validate()) {
            $formData = $form->getValue();

            //Item insert
            $allowedKeys                = ['item_name', 'price', 'description'];
            $itemInsertParams           = array_intersect_key($formData, array_flip($allowedKeys));
            $itemInsertParams['active'] = true;
            $itemId                     = ItemDB::insert($itemInsertParams);

            //Images upload

            $uploadedImage = array_merge([], $formData["image"]);

            /*
              $targetDirectory = 'uploads/';
              $imagePath       = $targetDirectory . basename($uploadedImage['name']);

              if (move_uploaded_file($uploadedImage['tmp_name'], $imagePath)) {
              echo 'Image uploaded: ' . $imagePath . '<br>';

              $itemImageInsertParams = [
              'item_id' => $itemId,
              'image_path' => $imagePath,
              ];

              $itemImageId = ItemDB::insert($itemImageInsertParams);
              } else {
              echo 'Error uploading image: ' . $uploadedImage['name'] . '<br>';
              } */


            ViewHelper::redirect(BASE_URL . "items?id=" . $itemId);
        } else {
            echo ViewHelper::render("view/items/item-form.php", [
                "title" => "Add item",
                "form" => $form
            ]);
        }
    }

    public static function edit() {
        $editForm   = new ItemsEditForm("edit_form");
        $deleteForm = new ItemsDeleteForm("delete_form");

        if ($editForm->isSubmitted()) {
            if ($editForm->validate()) {
                $formData = $form->getValue();

                $allowedKeys    = ['item_id', 'item_name', 'price', 'description'];
                $itemEditParams = array_intersect_key($formData, array_flip($allowedKeys));

                $uploadedImage = array_merge([], $formData["image"]);

                ItemDB::update($itemEditParams);
                ViewHelper::redirect(BASE_URL . "books?id=" . $data["id"]);
            } else {
                echo ViewHelper::render("view/items/item-form.php", [
                    "title" => "Edit item",
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
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
                $inputParameters['item_id'] = $data["id"];
                $item                       = ItemDB::get($inputParameters);

                $dataSource = new HTML_QuickForm2_DataSource_Array($item);
                $editForm->addDataSource($dataSource);
                $deleteForm->addDataSource($dataSource);

                echo ViewHelper::render("view/items/item-form.php", [
                    "title" => "Edit item",
                    "form" => $editForm,
                    "deleteForm" => $deleteForm
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
            }
        }
    }

    public static function delete() {
        $form = new ItemsDeleteForm("delete_form");
        $data = $form->getValue();

        if ($form->isSubmitted() && $form->validate()) {
            ItemDB::delete($data);
            ViewHelper::redirect(BASE_URL . "items");
        } else {
            if (isset($data["id"])) {
                $url = BASE_URL . "items/edit?id=" . $data["id"];
            } else {
                $url = BASE_URL . "items";
            }

            ViewHelper::redirect($url);
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
            $inputParameters['item_id'] = $data["id"];
            $inputParameters['active']  = 1;
            ItemDB::activateDeactivate($inputParameters);
        }

        ViewHelper::redirect(BASE_URL . "items");
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
            $inputParameters['item_id'] = $data["id"];
            $inputParameters['active']  = 0;
            ItemDB::activateDeactivate($inputParameters);
        }

        ViewHelper::redirect(BASE_URL . "items");
    }
}
