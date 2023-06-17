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

    public function actionIndex() {
            $mainGroups = $this->mainModel->getMainGroups();
            $title = 'Корзина';
            $h1 = 'Корзина';
            $errors = [];
            if(isset($_POST['productId'])  && ( isset($_POST['addToCart']) || isset($_POST['removeFromCart'] ))) {
                $product = $this->productModel->getById($_POST['productId']);
                $cart = [];
                if (isset($_COOKIE["cart"])) {
                    $cart = unserialize($_COOKIE["cart"]);  
                } 
                
                if (array_key_exists($product['product_id'],$cart)) {
                    if ( isset($_POST['addToCart'])) {
                        if ($cart[$product['product_id']] < $product['product_quantity'] ) {
                            $cart[$product['product_id']] += 1;   
                        }
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

                setcookie("cart", serialize($cart), time()+ 60 * 60 * 24 * 365, path:'/'); 
                header("Refresh: 0");
                
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
            
            

            require_once("views/cart/table.html");

        
    }



    public function actionOrder() {
        $mainGroups = $this->mainModel->getMainGroups();
            $title = 'Ваш заказ';
            $h1 = 'Ваш заказ';
        // addOrder    дописать
        if(isset($_POST['addOrder']) && !empty($_COOKIE["cart"]) && $this->isAuthorized )  {
            $cart = unserialize($_COOKIE["cart"]);

            $order = $this->cartModel->insertOrder($_COOKIE['uid'], $cart);
            if ($order) {
                setcookie("cart", "", time()+ 60 * 60 * 24 * 365, path:'/');
            }

        }
        //  во вью проверяем, что order существует и что он не false, то выводим сообщение, что заказ оформлен
        require_once("views/cart/table_order.html");
        // если не оформлен, то передает что-то не так.
    }
    
}

?>