<?php


//  здесь собраны все страницы не имеющие отдельной логики

class HowToBuyController {

    private $groupModel;
    private $howtobuyModel;
    public $isAuthorized;

    public function __construct() {
        $this->howtobuyModel = new HowToBuy();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->groupModel = new Group();
       
    }



    public function actionIndexHowToBuy() { 
        
        $menuProducts = $this-> groupModel->getOneLevelNameGroups(); 
        $title = 'Как купить?';
        require_once("views/howtobuy/howtobuy_table.html");



    }

}




?>