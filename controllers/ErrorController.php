<?php

class ErrorController {

    private $mainModel;
    public $menuProducts;

    public $isAuthorized;

    public function __construct() {
        $this->mainModel = new Main();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
    }

    public function action404() {
        $mainGroups = $this->mainModel->getMainGroups();
        header("HTTP/1.1 404 Not found");
        $title = "404 Not found";
        require_once("views/errors/404.html");
    }

}

?>