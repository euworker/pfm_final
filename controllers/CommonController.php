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

    





}




?>