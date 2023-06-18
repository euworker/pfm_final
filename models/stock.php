<?php 

class Stock {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getStocksCount() {
        $query = "SELECT count(*) AS `count`
                    FROM `stocks` 
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getNameStocks() {
        $query = "SELECT * 
                    FROM `stocks` 
                    LEFT JOIN `products` ON  `stock_product_id` = `product_id`
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getNameGroupByProductId($product_id) {
        $query = "SELECT `group_translit`
                    FROM `groups` 
                    WHERE `group_id` = $product_id
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_assoc($result);

    }



    public function getAllStocksPaginated($limit, $offset) {
        $query = "SELECT * FROM `stocks` 
                    LIMIT $offset, $limit
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    



    
}