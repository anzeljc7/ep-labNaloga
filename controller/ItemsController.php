<?php

require_once("model/ItemDB.php");
require_once("model/ItemImageDB.php");
require_once("model/AuthDB.php");
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
            $currUserType               = AuthDB::getCurrentUserType();

            echo ViewHelper::render("view/items/item-detail.php", [
                "item" => ItemDB::get($inputParameters),
                "uploadedImages" => ItemImageDB::get(['item_id' => $inputParameters['item_id']]),
                "showEdit" => isset($currUserType) && $currUserType == TYPE_SELLER
            ]);
        } else {
            echo ViewHelper::render("view/items/item-list.php", [
                "items" => ItemDB::getAll(),
            ]);
        }
    }

    public static function editImages() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        if ($data !== null && isset($data["id"])) {
            echo ViewHelper::render("view/items/item-edit-images.php", [
                "itemId" => $data["id"],
                "uploadedFiles" => ItemImageDB::get(['item_id' => $data["id"]]),
            ]);
        }
    }

    public static function uploadImages() {
        $rules = [
            "id" => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 1]
            ]
        ];

        $data = filter_input_array(INPUT_GET, $rules);

        if ($data !== null && isset($data["id"])) {

            $toDelete = ItemImageDB::get(['item_id' => $data["id"]]);
            foreach ($toDelete as $filePath) {
                $filePath = "/home/ep/NetBeansProjects/ep-labNaloga/static/images/" . $filePath['image_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            ItemImageDB::delete(['item_id' => $data["id"]]);
            $uploadedFiles = count($_FILES['images']['name']);

            for ($i = 0; $i < $uploadedFiles; $i++) {
                $targetFile = time() . basename($_FILES['images']['name'][$i]);
                ItemImageDB::insert(['item_id' => $data["id"], 'image_path' => $targetFile]);
                move_uploaded_file($_FILES['images']['tmp_name'][$i], "/home/ep/NetBeansProjects/ep-labNaloga/static/images/" . $targetFile);
            }
            ViewHelper::redirect(BASE_URL . "items/editImages?id=" . $data["id"]);
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
            ViewHelper::redirect(BASE_URL . "items/edit?id=" . $itemId);
        } else {
            echo ViewHelper::render("view/items/item-form.php", [
                "title" => "Add item",
                "form" => $form,
                "type" => "add"
            ]);
        }
    }

    public static function edit() {
        $editForm = new ItemsEditForm("edit_form");

        if ($editForm->isSubmitted()) {
            $formData       = $form->getValue();
            $allowedKeys    = ['item_id', 'item_name', 'price', 'description'];
            $itemEditParams = array_intersect_key($formData, array_flip($allowedKeys));
            if ($editForm->validate()) {
                ItemDB::update($itemEditParams);

                ViewHelper::redirect(BASE_URL . "items/edit?id=" . $itemEditParams['item_id']);
            } else {
                echo ViewHelper::render("view/items/item-form.php", [
                    "itemId" => $itemEditParams['item_id'],
                    "title" => "Edit item",
                    "form" => $editForm,
                    "type" => "edit"
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
                $files      = ItemImageDB::get(['item_id' => $inputParameters['item_id']]);

                echo ViewHelper::render("view/items/item-form.php", [
                    "itemId" => $inputParameters['item_id'],
                    "title" => "Edit item",
                    "form" => $editForm,
                    "type" => "edit"
                ]);
            } else {
                throw new InvalidArgumentException("editing nonexistent entry");
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
