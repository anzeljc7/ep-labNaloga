<?php

require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputFile.php';

abstract class ItemsAbstractForm extends HTML_QuickForm2 {

    public $item_name;
    public $price;
    public $description;
    public $image;
    public $button;

    public function __construct($id) {
        parent::__construct($id);

        $this->item_name = new HTML_QuickForm2_Element_InputText('item_name');
        $this->item_name->setAttribute('size', 50);
        $this->item_name->setLabel('Item name');
        $this->item_name->addRule('required', 'Item\'s name is mandatory.');
        $this->item_name->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->addElement($this->item_name);

        $this->price = new HTML_QuickForm2_Element_InputText('price');
        $this->price->setAttribute('size', 10);
        $this->price->setLabel('Price');
        $this->price->addRule('required', 'Price is mandatory.');
        $this->price->addRule('callback', 'Price should be a valid positive number with 2 decimal points.', array(
            'callback' => function ($value) {
                if (filter_var($value, FILTER_VALIDATE_FLOAT) !== false && $value >= 0) {
                    $roundedValue = round($value, 2);
                    return $value == $roundedValue;
                }
                return false;
            }));
        $this->addElement($this->price);

        $this->description = new HTML_QuickForm2_Element_Textarea('description');
        $this->description->setAttribute('rows', 10);
        $this->description->setAttribute('cols', 70);
        $this->description->setLabel('Item description');
        $this->description->addRule('required', 'Provide some text.');
        $this->addElement($this->description);

        $this->image = new HTML_QuickForm2_Element_InputFile('image');
        $this->image->setLabel('Upload Image');
        $this->image->addRule('required', 'Please select one image file.');
        $this->image->addRule('callback', 'Only image files are allowed.', array(
            'callback' => function ($value) {

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $value['tmp_name']);
                finfo_close($finfo);

                if (strpos($mime, 'image/') !== 0) {
                    return false;
                }

                return true;
            }));

        $this->addElement($this->image);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }
}

class ItemsInsertForm extends ItemsAbstractForm {

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Add item');
    }
}

class ItemsEditForm extends ItemsAbstractForm {

    public $itemId;
    public $active;

    public function __construct($id) {
        parent::__construct($id);

        $this->button->setAttribute('value', 'Edit item');

        $this->itemId = new HTML_QuickForm2_Element_InputHidden("item_id");
        $this->addElement($this->itemId);

        $this->active = new HTML_QuickForm2_Element_InputHidden("active");
        $this->addElement($this->active);
    }
}



