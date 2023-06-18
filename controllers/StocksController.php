<?php

//  require_once("models/manufacturer.php");

class StocksController {
    private $groupModel;
    private $stockModel;
    private $productModel;
    public $isAuthorized;
    public $menuProducts;

    public function __construct() {
        $this->stockModel = new Stock();
        $this->productModel = new Product();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;

    }

    public function actionIndex($page = 1) { 
        $total = $this->stockModel->getStocksCount();
        $limit = 6;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;    
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $stocks = $this->stockModel->getAllStocksPaginated($limit, $offset);
        
        // print_r($this->stockModel->getNameGroupByProductId($stocks['stock_product_id']));
        $title = 'Акции';
        require_once("views/stocks/table.html");

    }










}




?>




