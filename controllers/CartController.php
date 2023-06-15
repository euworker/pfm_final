<?php


//  здесь собраны все страницы не имеющие отдельной логики

class CartController {

    private $cartModel;
    private $groupModel;
    private $mainModel;
    private $productModel;

    public $isAuthorized;
    public $menuGroup;
    public $menuProducts;

    public function __construct() {
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
        $this->mainModel = new Main();
        $this->productModel = new Product();
        global $menuProducts;
        $this->menuProducts = $menuProducts;
        
          
    }

    // [18:47] Pavel A. Plyuhov

// ['1' => 1, '2' => 4]

// [18:48] Pavel A. Plyuhov

// { '1' => 1, '2' => 4 }

// [18:50] Pavel A. Plyuhov

// $arr[id] = 1; $arr[id] +=1; 

    public function actionIndex() {
            $mainGroups = $this->mainModel->getMainGroups();
            $title = 'Корзина';
            $h1 = 'Корзина';

            if(isset($_POST['productId'])  && ( isset($_POST['addToCart']) || isset($_POST['removeFromCart'] ))) {
                $product = $this->productModel->getById($_POST['productId']);
                $cart = [];
                if (isset($_COOKIE["cart"])) {
                    $cart = unserialize($_COOKIE["cart"]);   
                }
                if (array_key_exists($product['product_id'],$cart)) {
                    if ( isset($_POST['addToCart'])) {
                        $cart[$product['product_id']] += 1;
                    } else {
                        $cart[$product['product_id']] -= 1;
                        if ($cart[$product['product_id']] < 1) {
                            // удаляем элемент массива
                            unset($cart[$product['product_id']]);
                        }
                    }   
                } else {
                    $cart[$product['product_id']] = 1;
                }
                

                print('$cart[] - формирование массива ');
                print_r( $cart ) ;

                setcookie("cart", serialize($cart), time()+ 60 * 60 * 24 * 365, path:'/');
                // setcookie("products", "", time() + 2 * 24 * 3600, path:'/'); 
                header("Refresh: 0");

                print('unserialize - после записи');
                print_r( unserialize($_COOKIE["cart"] )) ; 
                
            } 
            
            if (isset($_COOKIE["cart"])) {

                $cart = unserialize($_COOKIE["cart"]);

                foreach ($cart as $product_id=>$count) {
                    $src = IMG_PRODUCT . $product_id . '.jpeg';
                    if (file_exists(IMG_ROOT. $product_id . '.jpeg')) {
                        $src = IMG_PRODUCT . $product_id . '.jpeg';    
                    } else {
                        $src = PRODUCT_MANUFACTURER_GROUP_IMG;
                    }
                    
                    $products[] = [
                        'product' => $this->productModel->getById($product_id),
                        'count' => $count,
                        'image' => $src
                    ];
                    
                }

            }


                // $get_cook[] = unserialize($_COOKIE["cart"]);
                // print('$get_cook2');
                // print_r($get_cook);
                // так будем расшифровывать
                // $get_cook = unserialize($_COOKIE['some_cookie_name']);
                //  затираем куки продукта
                // setcookie("products", "", time() + 2 * 24 * 3600, path:'/');   

                // $src = IMG_PRODUCT . $product['product_id']. '.jpeg';
                // if (file_exists(IMG_ROOT. $product. '.jpeg')) {
                //     // clearstatcache();
                //         $src = IMG_PRODUCT . $product['product_id']. '.jpeg';    
                //     }else{
                //         $src = PRODUCT_MANUFACTURER_GROUP_IMG;
                //     }
                
                

             require_once("views/cart/table.html");

        
    }

    
}

?>