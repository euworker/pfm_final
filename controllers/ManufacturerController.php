<?php

require_once("functions.php");
class ManufacturerController {
    private $groupModel;
    private $manufacturerModel;
    public $isAuthorized;

    public $menuProducts;


    public function __construct() {
        $this->manufacturerModel = new Manufacturer();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized(); 
        $this->groupModel = new Group();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
    }

 
    public function actionIndex($page = 1) { 
        $menuProducts = $this-> groupModel->getOneLevelNameGroups(); 
        $total = $this->manufacturerModel->getTotal();
        $limit = 3;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $manufacturers = $this->manufacturerModel->getAllPaginated($limit, $offset);
        $title = 'Производители';
        $src = PRODUCT_MANUFACTURER_GROUP_IMG;
        require_once("views/manufacturers/table.html");

    }


    public function actionAdd(){

        $errors = [];
        if (isset($_POST['manufacturerName'])) {
        $manufacturerName = htmlentities($_POST['manufacturerName']);
        $manufacturerDesc = htmlentities($_POST['manufacturerDesc']);
        if (empty($manufacturerName) 
            || empty($manufacturerDesc) 
            || check_length($manufacturerDesc,1,980) 
            || check_length($manufacturerName,1,99)) {
            $errors[] = 'Поля не могут быть пусты или слишком длинные';
        }     
        
        if (empty($errors)) {
            $this->manufacturerModel->insert($manufacturerName,$manufacturerDesc);
            header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
        }

    }
        require_once("views/manufacturers/form.html");
    } 



    public function actionEdit($id){
        $errors = [];
        $manufacturer = $this->manufacturerModel->GetById($id);

        if (isset($_POST['manufacturerName'])) {
        $manufacturerName = htmlentities($_POST['manufacturerName']);
        $manufacturerDesc = htmlentities($_POST['manufacturerDesc']);            

        if (empty($manufacturerName) 
            || empty($manufacturerDesc) 
            || check_length($manufacturerDesc,1,980) 
            || check_length($manufacturerName,1,99)) {
            $errors[] = 'Поля не могут быть пусты или слишком длинные';
        } 

        if (empty($errors)) { 
            if ($manufacturer['manufacturer_name'] === $manufacturerName) {
                header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
            }
            if ($manufacturer['manufacturer_name'] !== $manufacturerName) {
                 $result = $this->manufacturerModel->edit($manufacturerName,$manufacturerDesc, $id);
                if ($result) {
                    header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
                } else {
                    $errors[] = "Не удалось добавить данные в таблицу.";
                }
                }
            
            header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
        }
    }
        $manufacturer = $this->manufacturerModel->GetById($id);
        require_once("views/manufacturers/form.html");

    } 


    public function actionDelete($id) {
        $errors = [];

        if ( !is_numeric($id) ) {
            $errors[] = "Не число";
        }
        
        $this->manufacturerModel->remove($id);
        header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
    }




}




?>