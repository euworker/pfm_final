<?php


//  здесь собраны все страницы не имеющие отдельной логики

class HowToBuyController {

    private $howtobuyModel;
    public $isAuthorized;

    public function __construct() {
        $this->howtobuyModel = new HowToBuy();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }



    public function actionIndexHowToBuy() { 
        $title = 'Как купить?';
        require_once("views/howtobuy/howtobuy_table.html");



    }

}




?>