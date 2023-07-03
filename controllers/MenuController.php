<?php

//  require_once("models/manufacturer.php");

class MenuController {

    private $groupModel;

    private $menuModel;
    public $isAuthorized;
    
    public $menuProducts;

    public function __construct() {
        $this->groupModel = new Group();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->menuProducts = $this-> menuModel->getOneLevelNameGroups();
        global $menuProducts;
        $this->menuProducts = $menuProducts;   
        
    }

}




?>




