<?php

//  require_once("models/manufacturer.php");

class StocksController {

    private $stockModel;
    public $isAuthorized;

    public function __construct() {
        $this->stockModel = new Stock();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    public function actionIndex($page = 1) { 
        // $manufacturers = $this->mainModel->getTotal();
        $total = $this->stockModel->getStocksCount();
        $limit = 6;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;    
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $stocks = $this->stockModel->getAllStocksPaginated($limit, $offset);
        $title = 'Акции';
        require_once("views/stocks/table.html");

    }










}




?>




