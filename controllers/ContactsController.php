<?php


//  здесь собраны все страницы не имеющие отдельной логики

class ContactsController {

    private $contactsModel;
    private $groupModel;
    public $isAuthorized;
    public $menuProducts;

    public function __construct() {
        $this->contactsModel = new Contacts();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->groupModel = new Group();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
        
    }

    

    public function actionIndexcontacts() { 
        
        $menuProducts = $this-> groupModel->getOneLevelNameGroups(); 
        $title = 'Контакты';
        require_once("views/contacts/contacts_table.html");
       
        



    }

}




?>