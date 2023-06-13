<?php


//  здесь собраны все страницы не имеющие отдельной логики

class CartController {

    private $cartModel;
    private $groupModel;
    private $mainModel;
    private $productModel;

    public $isAuthorized;
    public $menuGroup;

    public function __construct() {
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->mainModel = new Main();
        $this->productModel = new Product();
          
    }


    public function actionIndex() {
            $mainGroups = $this->mainModel->getMainGroups();
            $title = 'Корзина';
            $h1 = 'Корзина';

            if(isset($_POST['addToCart']) && isset($_COOKIE["products"])) {
                $product = $this->productModel->getById($_COOKIE["products"]);
                if (isset($_COOKIE["cart"])) {
                    $cart = unserialize($_COOKIE["cart"]);

                    if (in_array($product,$cart)) {
                        header("Refresh: 0");
                    }
                    
                }

                $cart[] = $product['product_id'];

                print('$cart[] - формирование массива ');
                print_r( $cart ) ;

                setcookie("cart", serialize($cart), time()+ 60 * 60 * 24 * 365, path:'/');
                header("Refresh: 0");
                print('unserialize - после записи');
                print_r( unserialize($_COOKIE["cart"] )) ; 
                
            } 
            
            if (isset($_COOKIE["cart"])) {
                $cart = unserialize($_COOKIE["cart"]);
                foreach ($cart as $products) {
                    $product = $this->productModel->getById($products);
                    print ('Продукт ' .  $product['product_id'] . ';');

                }

            }


                $get_cook[] = unserialize($_COOKIE["cart"]);
                print('$get_cook2');
                print_r($get_cook);
                // так будем расшифровывать
                // $get_cook = unserialize($_COOKIE['some_cookie_name']);
                //  затираем куки продукта
                setcookie("products", "", time() + 2 * 24 * 3600, path:'/');          
                $src = IMG_PRODUCT . $product['product_id']. '.jpeg';
                if (file_exists(IMG_ROOT. $product. '.jpeg')) {
                    // clearstatcache();
                        $src = IMG_PRODUCT . $product['product_id']. '.jpeg';    
                    }else{
                        $src = PRODUCT_MANUFACTURER_GROUP_IMG;
                    }
                
                

             require_once("views/cart/table.html");

        
    }

    
}

?>