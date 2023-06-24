<?php

class Cart {

private $connect;
    

public function __construct(){

    $this->connect = DB::getConnection();

}

public function insertOrder($userId, $cart_user){
    $query = "INSERT INTO `orders` (`order_user_id`, `order_status_id`) 
        VALUES ('$userId', '1' )";
        
    if (mysqli_query( $this->connect, $query)) {
        $cart =  "SELECT LAST_INSERT_ID()";
        // поллучаем id автоинкремента
        $result = mysqli_query( $this->connect, $cart);
        $order_id = mysqli_fetch_assoc($result);
        // вытаскиваем элемент массива, на котором указатель
        $order_id = current($order_id);

        foreach ($cart_user as $key => $item) {
            //  по key нужно найти товар и вытащить его цену


            // $cart_product_price = 
            $query = "INSERT INTO `carts` (`cart_product_id`, `cart_product_count` , `cart_order_id` 
            -- `cart_product_price`
            ) 
            VALUES ('$key', '$item', '$order_id' )";
            mysqli_query( $this->connect, $query);

        }
        // если все проходит нормально - возвращаем номер корзины

        return $order_id;
    }
    
    return false;
}  







}