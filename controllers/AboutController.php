<?php


//  здесь собраны все страницы не имеющие отдельной логики

class AboutController {
    private $groupModel;
    private $aboutModel;
    public $isAuthorized;

    public function __construct() {
        $this->aboutModel = new About();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->groupModel = new Group();
        $menuProducts = $this-> groupModel->getOneLevelNameGroups();
    }

    


    public function actionIndexAbout() { 
        
        $title = 'О нас';
        require_once("views/about/about_table.html");



    }

}




?>