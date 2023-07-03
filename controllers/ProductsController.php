<?php 
require_once("functions.php");

class ProductsController {
    private $productModel;
    private $manufacturerModel;
    private $groupModel;
    public $isAuthorized;
    public $menuProducts;


    public function __construct() {
        $this->productModel = new Product();
        $this->manufacturerModel = new Manufacturer();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
    }

    public function actionGroup($group_name_translit, $page = 1) {
        
        $level = $this ->productModel->getGroupLevel($group_name_translit);

        if ($level === '2')  {
            $total = $this->productModel->getTotalProductsInGroup($group_name_translit);
            $limit = 6;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $products = $this->productModel->getProductsByNameTranslitGroup($group_name_translit, $limit, $offset);

            if (count($products)==0) {
                $title = 'Товары';
                $empty = "К сожалению, пусто. Наполняем товарами)";
                } else {
                    $h1 = $products[0]['group_name'];
                    $title = $products[0]['group_name'] . PRODUCT_TITLE;
                    $description = $products[0]['group_name']. PRODUCT_DESCRIPTION;
                }
            require_once("views/products/table.html");
        } else {
            $total = $this->productModel->getTotalChildGroupsInParentGroup($group_name_translit);
            $limit = 3;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $groups = $this->productModel->getGroupByNameTranslitGroup($group_name_translit, $limit, $offset);

            if (count($groups)==0) {
                $title = 'Группа товаров';
                $empty = "К сожалению, пусто. Наполняем )";
            } else {
                $h1 = $groups[0]['parent_group_name'];
                $title = $groups[0]['parent_group_name'] . PRODUCT_TITLE;
                $description = $groups[0]['parent_group_name']. PRODUCT_DESCRIPTION;
            }
            require_once("views/products/table.html");
        }
    }
  
    public function actionProduct($group_name_translit,$product_id) {

        if(isset($group_name_translit) && isset($product_id) ) 
        try{
            $product = $this->productModel->getById($product_id);
            } catch (Exception $e) {
                header('Location: '. FULL_SITE_ROOT . 'errors/404');
            }
        
        $h1 = $product['product_name'] . ' ' . $product['product_art'];
        $title = $product['product_name'] . ' ' . $product['product_art']. PRODUCT_TITLE;
        $description = $product['product_name'] . ' ' . $product['product_art']. PRODUCT_DESCRIPTION;
        
        if (file_exists(IMG_ROOT. $product['product_id']. '.jpeg')) {
                $src = IMG_PRODUCT . $product['product_id']. '.jpeg';    
            }else{
                $src = PRODUCT_MANUFACTURER_GROUP_IMG;
        }
        require_once("views/products/product_table.html"); 
    } 

    public function actionGetProductByGroup($group_id) { 
        $products = $this->productModel->getProductByGroup($group_id);
        $title = 'Товары';
        require_once("views/products/table.html");
    }  

}


?>