<?php 

class Product {


    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getAll() {
        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
                    `manufacturer_name`, `manufacturer_id`
                FROM `products`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` =''
                GROUP BY `product_id`
                ORDER BY `product_id` DESC
                "; 
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    public function getById($id) {
        $query = "SELECT 
         `product_id`,`product_art`,`product_name`,`product_description`,`product_price`,`product_quantity`,
         `product_manufacturer_id` AS `manufacturers_getById`, `manufacturer_name`, `group_parent_id`, `group_name`, `group_translit`, `stock_products_price`
        FROM `products` 
        LEFT JOIN `groups` ON `group_id` = `product_group_id` 
        LEFT JOIN `manufacturers` ON `manufacturer_id` = `product_manufacturer_id`
        LEFT JOIN `stocks` ON `stock_product_id` = `product_id`
        WHERE   `product_id` = $id;
        ";
        $result = mysqli_query($this->connect, $query);
        $arr = mysqli_fetch_assoc($result);
        // провервка в модели 
        if (empty($arr['product_id'])) {
            // если, пустой или ошибка, то try отловит
            throw new Exception(' Error ');
        }
        
        return $arr;
    }

    public function getProductsByNameTranslitGroup($group_name_translit, $limit, $offset) {
        $query = " SELECT `group_parent_id`
            FROM `groups`
            WHERE `group_translit` = '$group_name_translit'
            ";
        $result = mysqli_query($this->connect, $query);
        $parent_group_id = mysqli_fetch_assoc($result)['group_parent_id'];

        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
            `manufacturer_name`, `manufacturer_id`, `group_translit`, `group_name`, 
            (SELECT `group_translit`
                    FROM `groups` 
                    WHERE `group_id` = '$parent_group_id') as `parent_group_name`
            FROM `products`
            LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
            LEFT JOIN `groups` ON `group_id` = `product_group_id`
            WHERE (`product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` ='') AND `group_translit` = '$group_name_translit'
            GROUP BY `product_id`
            ORDER BY `product_id` ASC
            LIMIT $offset, $limit
            ";
            

        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getGroupByNameTranslitGroup($group_name_translit, $limit, $offset) { 
       $query = " SELECT `group_id`
            FROM `groups`
            WHERE `group_translit` = '$group_name_translit'
            ";
        $result = mysqli_query($this->connect, $query);
        $parent_group_id = mysqli_fetch_assoc($result)['group_id'];

        $query ="SELECT `group_id`, `group_name`, `group_translit`, `group_level`,  `group_parent_id`, 
            (SELECT `group_name`
                FROM `groups` 
                WHERE `group_translit` = '$group_name_translit') as `parent_group_name`
            FROM `groups`
            WHERE group_parent_id = '$parent_group_id' 
            LIMIT $offset, $limit
            ";    
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    

    public function getAllPaginated($limit, $offset) {
        $query = "SELECT * FROM `products` 
                    WHERE `product_is_deleted` = 0
                    LIMIT $offset, $limit
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    public function getGroupLevel($group_name_translit) {
        $query = "SELECT group_level 
                    FROM `groups` 
                    WHERE `group_translit` = '$group_name_translit';
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['group_level'];
    }


    public function getTotal() {
        $query = "SELECT count(*) AS `count`
                    FROM `products` 
                    WHERE `product_is_deleted` = 0;
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];

    }

    public function getTotalProductsInGroup($group_name_translit) {
        $query = "SELECT count(*) AS `count`
                    FROM `products`
                    LEFT JOIN `groups` ON `group_id` = `product_group_id`
                    WHERE `product_is_deleted` = 0 AND `group_translit` = '$group_name_translit'
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];

    }

    public function getTotalChildGroupsInParentGroup($group_name_translit) {

        $query = " SELECT `group_id`
            FROM `groups`
            WHERE `group_translit` = '$group_name_translit'
            ";
        $result = mysqli_query($this->connect, $query);
        $parent_group_id = mysqli_fetch_assoc($result)['group_id'];

        $query = "SELECT count(*) AS `count`
                    FROM `groups`
                    WHERE `group_parent_id` = '$parent_group_id'
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getProductByGroup($group_id) {
        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`,
                 `manufacturer_name`, `manufacturer_id`
                FROM `products`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                LEFT JOIN `groups` ON `product_group_id` = `group_id`

                WHERE (`product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` ='') AND `product_group_id` = $group_id
                GROUP BY `product_id`
                ORDER BY `product_id` DESC
                "; 
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


}


?>