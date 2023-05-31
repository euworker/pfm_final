<?php


//  здесь собраны все страницы не имеющие отдельной логики

class ContactsController {

    private $contactsModel;
    public $isAuthorized;

    public function __construct() {
        $this->contactsModel = new Contacts();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    

    public function actionIndexcontacts() { 
        $title = 'Контакты';
        require_once("views/contacts/contacts_table.html");



    }

}




?>