<?php

//  require_once("models/manufacturer.php");

class MainController {

    private $mainModel;
    public $isAuthorized;
    public $menuProducts;



    public function __construct() {
        $this->mainModel = new Main();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
    }

    

    public function actionIndex($page = 1) { 
        
        // $manufacturers = $this->mainModel->getTotal();
        $mainGroups = $this->mainModel->getMainGroups();
        $title = 'Платформа ИТ - интернет-магазин техники и электроники';
        $description = 'Электроника и техника по выгодным ценам. Огромный ассортимент товаров, приятные цены, качественные консультации. Платформа ИТ - партнер для дома и бизнеса!';
        require_once("views/main/table.html");



    }


}




?>