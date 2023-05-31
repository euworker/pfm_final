<?php

//  require_once("models/manufacturer.php");

class ManufacturerController {

    private $manufacturerModel;
    public $isAuthorized;

    public function __construct() {
        $this->manufacturerModel = new Manufacturer();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

 
    public function actionIndex($page = 1) { 
        $total = $this->manufacturerModel->getTotal();
        $limit = 3;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $manufacturers = $this->manufacturerModel->getAllPaginated($limit, $offset);
        $title = 'Производители';
        require_once("views/manufacturers/table.html");


    }

    public function actionAdd(){
        $errors = [];
        if (isset($_POST['manufacturerName'])) {
        $manufacturerName = htmlentities($_POST['manufacturerName']);
        $manufacturerDesc = htmlentities($_POST['manufacturerDesc']);
        // todo проверки !!! регулярки -> если проверка на регулярку не проходит, то записаваем ошибку в
        // errors/ офибку придумаваем сами
        // проверка - значение есть в таблице ! 
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
        // todo проверки !!! регулярки -> если проверка на регулярку не проходит, то записаваем ошибку в
        // errors/ офибку придумаваем сами
        // рекущее значение фио, не совпадает с существующим  
        if (empty($errors)) { 
            if ($manufacturer['manufacturer_name'] === $manufacturerName) {
                header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
            }
            if ($manufacturer['manufacturer_name'] !== $manufacturerName) {
                 // TODO проверка - значение есть в таблице !
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
        // TODO проверка на то, что id передан правильно.
        // id соответствует регулярке 
        // id есть в базе
        $this->manufacturerModel->remove($id);
        header('Location: ' . FULL_SITE_ROOT . 'manufacturers');
    }




}




?>