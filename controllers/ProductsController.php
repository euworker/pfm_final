<?php 
require_once("functions.php");

class ProductsController {
    private $productModel;
    private $manufacturerModel;
    private $groupModel;
    public $isAuthorized;


    public function __construct() {
        $this->productModel = new Product();
        $this->manufacturerModel = new Manufacturer();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->groupModel = new Group();
    }

    public function actionIndex($page = 1) { 
        $menuProducts = $this-> groupModel->getOneLevelNameGroups(); 
        $total = $this->productModel->getTotal();
        $limit = 3;
        $currentPage = $page;
        $index = 'page=';
        $offset = ($page - 1) * $limit;
        $pagination = new Pagination($total, $currentPage, $limit, $index);
        $products = $this->productModel->getAllPaginated($limit, $offset);
        $title = 'Товары';
        require_once("views/products/table.html");
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
            // print('до' . $limit . ' ' . $offset);
            $products = $this->productModel->getProductsByNameTranslitGroup($group_name_translit, $limit, $offset);
            // дописать 

            if (count($products)==0) {
                $title = 'Товары';
                $empty = "К сожалению, пусто. Наполняем товарами)";
                } else {
                    $h1 = $products[0]['group_name'];
                    $title = 'Товары ' . $products[0]['group_name'];
                }
            // print('после' . $limit . ' ' . $offset);
            // print_r($products);

    
            require_once("views/products/table.html");

        } else {
            $total = $this->productModel->getTotalChildGroupsInParentGroup($group_name_translit);
            print($total);
            $limit = 3;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            // print('до' . $limit . ' ' . $offset);
            $groups = $this->productModel->getGroupByNameTranslitGroup($group_name_translit, $limit, $offset);
            // дописать 

            if (count($groups)==0) {
                $title = 'Группа товаров';
                $empty = "К сожалению, пусто. Наполняем )";
            } else {
                $h1 = $groups[0]['parent_group_name'];
                $title = 'Товары ' . $groups[0]['parent_group_name'];
            }
            // print('после' . $limit . ' ' . $offset);
            // print_r($products);

    
            require_once("views/products/table.html");
        }
    }

    
        
    public function actionProduct($group_name_translit,$product_id) {
        if(isset($group_name_translit) && isset($product_id) )   
        $product = $this->productModel->getById($product_id);
        
        $h1 = $product['product_name'] . ' ' . $product['product_art'];
        $title = $product['product_name'] . ' ' . $product['product_art']. PRODUCT_TITLE;
        $description = $product['product_name'] . ' ' . $product['product_art']. PRODUCT_DESRIPTION;
        $src = IMG_PRODUCT . $product['product_id']. '.jpeg';
        // echo (file_exists(IMG_ROOT. $product['product_id']. '.jpeg'));
        // die;
        // проверка фото
        // IMG_PRODUCT
        if (file_exists(IMG_ROOT. $product['product_id']. '.jpeg')) {
            // clearstatcache();
            $src = IMG_PRODUCT . $product['product_id']. '.jpeg';    
        }else{
   
            $src = PRODUCT_MANUFACTURER_GROUP_IMG;
        }
         require_once("views/products/product_table.html");

    } // todo сделать функцию mb_str_low, preg_replace - удалить всё кроме 




    public function actionAdd() {
        if (isset($_POST['product_art'])){
            $product_art = clean($_POST['product_art']);
            $product_name = clean($_POST['product_name']);
            $product_description = clean($_POST['product_description']);
            $product_price = clean($_POST['product_price']);
            $product_quantity = clean($_POST['product_quantity']);
            $product_img_link = clean($_POST['product_img_link']);
            // $product_warehouse_id = clean($_POST['product_warehouse_name']);
            $product_manufacturer_id = clean($_POST['product_manufacturer_name']);
            // $product_group_id = clean($_POST['product_group_name']);

            if (
                empty($product_art) 
                || check_length($product_art,1,40)
                || empty($product_name) 
                || check_length($product_name,1,100)
                || check_length($product_description,0,980)
                || name_check($product_name) === 1 
                || check_length($product_name,1,100)
                || empty($product_price) 
                || ($product_price < 0 ||  $product_price > 99999999)  
                || !is_numeric($product_price) 
                // || empty($product_warehouse_id)
                // || empty($product_group_id)
            )  
             {
                echo 'Не соблюдены условия!'; 
                
            } else {
                $data = array (
                   'product_art'=> $product_art,
                   'product_name'=> $product_name,
                    'product_description'=> $product_description,
                    'product_price' => $product_price,
                    'product_quantity' => $product_quantity,
                    'product_img_link' => $product_img_link,
                    'product_manufacturer_id' => $product_manufacturer_id
                );
                $this->productModel->add($data);
                header('Location: '. FULL_SITE_ROOT . 'products');
            }


        }


        $manufacturers = $this->manufacturerModel->getAll();
        include_once('views/products/form.html');
    }

    public function actionEdit($id) {

        $product = $this->productModel->getById($id);
        $product['manufacturers_getById'] = explode(',',$product['manufacturers_getById']);
        
        if (isset($_POST['product_art'])){
            $product_art = clean($_POST['product_art']);
            $product_name = clean($_POST['product_name']);
            $product_description = clean($_POST['product_description']);
            $product_price = clean($_POST['product_price']);
            $product_quantity = clean($_POST['product_quantity']);
            $product_img_link = clean($_POST['product_img_link']);
            // $product_warehouse_id = clean($_POST['product_warehouse_name']);
            $product_manufacturer_id = clean($_POST['product_manufacturer_name']);
            // $product_group_id = clean($_POST['product_group_name']);

            if (
                empty($product_art) 
                || check_length($product_art,1,40)
                || empty($product_name) 
                || check_length($product_name,1,100)
                || check_length($product_description,0,980)
                || name_check($product_name) === 1 
                || check_length($product_name,1,100)
                || empty($product_price) 
                || ($product_price < 0 ||  $product_price > 99999999)  
                || !is_numeric($product_price) 
                // || empty($product_warehouse_id)
                // || empty($product_group_id)
            )  
             {
                echo 'Не соблюдены условия!'; 
                
            } else {


                $data = array (
                   'product_art'=> $product_art,
                   'product_name'=> $product_name,
                    'product_description'=> $product_description,
                    'product_price' => $product_price,
                    'product_quantity' => $product_quantity,
                    'product_img_link' => $product_img_link,
                    'product_manufacturer_id' => $product_manufacturer_id
                );
                // забираем массив объект из базы. превращаем в масиив. сравниваем 2 массива. 
                // расхождение превращаем из масиива в строки  или инты для записи в базу, обновляем только новые стркои 
                //  if ( $this->productModel->dataDif($data,$product) == 1 ); 
                $this->productModel->edit($data,$id);
                header('Location: '. FULL_SITE_ROOT . 'products');
                
            }


        }


        $manufacturers = $this->manufacturerModel->getAll();
        include_once('views/products/form.html');
    }
    
    public function actionDelete($id) {
        $errors = [];
        // TODO проверка на то, что id передан правильно.
        // id соответствует регулярке 
        // id есть в базе
        $this->productModel->remove($id);
        header('Location: ' . FULL_SITE_ROOT . 'products');
    }


    public function actionGetProductByGroup($group_id) { 
        $products = $this->productModel->getProductByGroup($group_id);
        $title = 'Товары';
        require_once("views/products/table.html");
    }

}


?>