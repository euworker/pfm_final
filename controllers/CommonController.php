<?php


//  здесь собраны все страницы не имеющие отдельной логики

class CommonController {

    private $commonModel;
    public $isAuthorized;

    public function __construct() {
        $this->commonModel = new Common();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    




    public function actionIndexHowToBuy() { 
        $title = 'Как купить?';
        require_once("views/common/howtobuy_table.html");



    }

    public function actionIndexcontacts() { 
        $title = 'Контакты';
        require_once("views/common/contacts_table.html");



    }

    public function actionIndexAbout() { 
        $title = 'О нас';
        require_once("views/common/about_table.html");



    }

}




?>