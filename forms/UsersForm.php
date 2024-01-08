<?php

require_once("model/PostNumDB.php");
require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Container/Fieldset.php';
require_once 'HTML/QuickForm2/Element/InputSubmit.php';
require_once 'HTML/QuickForm2/Element/InputText.php';
require_once 'HTML/QuickForm2/Element/Textarea.php';
require_once 'HTML/QuickForm2/Element/InputPassword.php';
require_once 'HTML/QuickForm2/Element/Select.php';

class LoginForm extends HTML_QuickForm2 {

    public $email;
    public $password;

    public function __construct($id) {
        parent::__construct($id);
        
        $httpsUrl = str_replace('http://', 'https://', BASE_URL);

        parent::__construct($id, "get", ["action" => $httpsUrl . "login"]);

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 100);
        $this->email->setLabel('Email');
        $this->email->addRule('required', 'Provide your email.');
        $this->email->addRule('regex', 'Provide valid email.', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
        $this->addElement($this->email);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('placeholder', 'Password');
        $this->password->setLabel('Password');
        $this->password->addRule('required', 'Please enter your password');
        $this->addElement($this->password);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
        $this->button->setAttribute('value', 'Login');

        $this->addElement($this->button);

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }
}

abstract class UserAbstractForm extends HTML_QuickForm2 {

    public $name;
    public $surname;
    public $email;
    public $password;
    public $button;

    public function __construct($id) {
        parent::__construct($id);
        $this->name = new HTML_QuickForm2_Element_InputText('name');
        $this->name->setAttribute('size', 70);
        $this->name->setLabel('Name');
        $this->name->addRule('required', 'Provide your name.');
        $this->name->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->addElement($this->name);

        $this->surname = new HTML_QuickForm2_Element_InputText('surname');
        $this->surname->setAttribute('size', 70);
        $this->surname->setLabel('Surname');
        $this->surname->addRule('required', 'Provide your surname.');
        $this->surname->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');
        $this->addElement($this->surname);

        $this->email = new HTML_QuickForm2_Element_InputText('email');
        $this->email->setAttribute('size', 100);
        $this->email->setLabel('Email');
        $this->email->addRule('required', 'Provide your email.');
        $this->email->addRule('regex', 'Provide valid email.', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/');
        $this->addElement($this->email);

        $this->button = new HTML_QuickForm2_Element_InputSubmit(null);
    }
}

abstract class CustomerAbstractForm extends UserAbstractForm {

    public $street;
    public $houseNumber;
    public $postalCode;

    public function __construct($id) {
        parent::__construct($id);

        $this->street = new HTML_QuickForm2_Element_InputText('street');
        $this->street->setAttribute('placeholder', 'Street');
        $this->street->setLabel('Street');
        $this->street->addRule('required', 'Please enter your street');
        $this->street->addRule('regex', 'Letters only.', '/^[a-zA-ZščćžŠČĆŽ ]+$/');

        $this->houseNumber = new HTML_QuickForm2_Element_InputText('house_number');
        $this->houseNumber->setAttribute('placeholder', 'House Number');
        $this->houseNumber->setLabel('House Number');
        $this->houseNumber->addRule('required', 'Please enter your house number');

        $this->postalCode = new HTML_QuickForm2_Element_Select('postal_code');
        $this->postalCode->setLabel("Postal code");
        $this->postalCode->loadOptions(PostNumDB::getAll());
        $this->postalCode->addRule('required', 'PLease enter your postal code.');

        $this->addRecursiveFilter('trim');
        $this->addRecursiveFilter('htmlspecialchars');
    }
}

class RegisterForm extends CustomerAbstractForm {

    public $password;
    public $repeatPassword;

    public function __construct($id) {
        parent::__construct($id);
        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('placeholder', 'Password');
        $this->password->setLabel('Password');
        $this->password->addRule('required', 'Please enter your password');
        $this->addElement($this->password);

        $this->repeatPassword = new HTML_QuickForm2_Element_InputPassword('repeatPassword');
        $this->repeatPassword->setAttribute('placeholder', 'Repeat Password');
        $this->repeatPassword->setLabel('Repeat Password');
        $this->repeatPassword->addRule('required', 'Please repeat your password');
        $this->repeatPassword->addRule('eq', 'Passwords do not match', $this->password);
        $this->addElement($this->repeatPassword);

        $this->addElement($this->street);
        $this->addElement($this->houseNumber);
        $this->addElement($this->postalCode);

        $this->button->setAttribute('value', 'Register');
        $this->addElement($this->button);
    }
}

class SellerAddForm extends UserAbstractForm {

    public $password;

    public function __construct($id) {
        parent::__construct($id);

        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('placeholder', 'Password');
        $this->password->setLabel('Password');
        $this->password->addRule('required', 'Please enter your password');
        $this->addElement($this->password);

        $this->repeatPassword = new HTML_QuickForm2_Element_InputPassword('repeatPassword');
        $this->repeatPassword->setAttribute('placeholder', 'Repeat Password');
        $this->repeatPassword->setLabel('Repeat Password');
        $this->repeatPassword->addRule('required', 'Please repeat your password');
        $this->repeatPassword->addRule('eq', 'Passwords do not match', $this->password);
        $this->addElement($this->repeatPassword);

        $this->button->setAttribute('value', 'Add account');
        $this->addElement($this->button);
    }
}

class CustomerSelfEditForm extends CustomerAbstractForm {

    public $password;
    public $newPassword;
    public $userId;
    public $active;

    public function __construct($id) {
        parent::__construct($id);
        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('placeholder', 'Password');
        $this->password->setLabel('Password');
        $this->password->addRule('required', 'Please enter your password');
        $this->addElement($this->password);

        $this->newPassword = new HTML_QuickForm2_Element_InputPassword('newPassword');
        $this->newPassword->setAttribute('placeholder', 'New password');
        $this->newPassword->setLabel('New password');
        $this->newPassword->addRule('neq', 'Passwords are equal', $this->password);
        $this->addElement($this->newPassword);

        $this->addElement($this->street);
        $this->addElement($this->houseNumber);
        $this->addElement($this->postalCode);

        $this->userId = new HTML_QuickForm2_Element_InputHidden("user_id");
        $this->addElement($this->userId);

        $this->active = new HTML_QuickForm2_Element_InputHidden("active");
        $this->addElement($this->active);

        $this->button->setAttribute('value', 'Edit your account');
        $this->addElement($this->button);
    }
}

class CustomerEditForm extends CustomerAbstractForm {

    public $userId;
    public $active;

    public function __construct($id) {
        parent::__construct($id);

        $this->addElement($this->street);
        $this->addElement($this->houseNumber);
        $this->addElement($this->postalCode);

        $this->userId = new HTML_QuickForm2_Element_InputHidden("user_id");
        $this->addElement($this->userId);

        $this->active = new HTML_QuickForm2_Element_InputHidden("active");
        $this->addElement($this->active);

        $this->button->setAttribute('value', 'Edit account');
        $this->addElement($this->button);
    }
}

class SellerAdminSelfEditForm extends UserAbstractForm {

    public $newPassword;
    public $password;
    public $userId;
    public $active;

    public function __construct($id) {
        parent::__construct($id);
        $this->password = new HTML_QuickForm2_Element_InputPassword('password');
        $this->password->setAttribute('placeholder', 'Password');
        $this->password->setLabel('Password');
        $this->password->addRule('required', 'Please enter your password');
        $this->addElement($this->password);

        $this->newPassword = new HTML_QuickForm2_Element_InputPassword('newPassword');
        $this->newPassword->setAttribute('placeholder', 'New password');
        $this->newPassword->setLabel('New password');
        $this->newPassword->addRule('neq', 'Passwords are equal', $this->password);
        $this->addElement($this->newPassword);

        $this->userId = new HTML_QuickForm2_Element_InputHidden("user_id");
        $this->addElement($this->userId);
        $this->active = new HTML_QuickForm2_Element_InputHidden("active");
        $this->addElement($this->active);

        $this->button->setAttribute('value', 'Edit your account');
        $this->addElement($this->button);
    }
}

class SellerEditForm extends UserAbstractForm {

    public $userId;
    public $active;

    public function __construct($id) {
        parent::__construct($id);

        $this->userId = new HTML_QuickForm2_Element_InputHidden("user_id");
        $this->addElement($this->userId);

        $this->active = new HTML_QuickForm2_Element_InputHidden("active");
        $this->addElement($this->active);

        $this->button->setAttribute('value', 'Edit account');
        $this->addElement($this->button);
    }
}
