<?php

//  require_once("models/manufacturer.php");

class MainController {

    private $mainModel;
    public $isAuthorized;



    public function __construct() {
        $this->mainModel = new Main();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $menu = new Menu();
// переменная существет только до хапуска роутера
        $menuProducts = $menu -> getOneLevelNameGroups();
       

    }

    




    public function actionIndex($page = 1) { 
        
        // $manufacturers = $this->mainModel->getTotal();
        $mainGroups = $this->mainModel->getMainGroups();

        // $total = $this->mainModel->getManufacturersTotal();
        // $limit = 3;
        // $currentPage = $page;
        // $index = 'page=';
        // $offset = ($page - 1) * $limit;
        // $pagination = new Pagination($total, $currentPage, $limit, $index);
        // $manufacturers = $this->mainModel->getAllManufacturersPaginated($limit, $offset);
        $title = 'Главная страница';
        require_once("views/main/table.html");



    }


    // public function actionGroup(){
    //     $errors = [];
    //     if (isset($_POST['manufacturerName'])) {
    //     $manufacturerName = htmlentities($_POST['manufacturerName']);
    //     $manufacturerDesc = htmlentities($_POST['manufacturerDesc']);
    //     // todo проверки !!! регулярки -> если проверка на регулярку не проходит, то записаваем ошибку в
    //     // errors/ офибку придумаваем сами
    //     // проверка - значение есть в таблице ! 
    //     if (empty($errors)) {
    //         $this->manufacturerModel->insert($manufacturerName,$manufacturerDesc);
    //         header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
    //     }
    // }
    //     require_once("views/manufacturers/form.html");
    // } 









}




?>