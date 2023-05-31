<?php 

class Product {


    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getAll() {

        
        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
                    `product_img_link`, `warehouse_name`, `manufacturer_name`, `manufacturer_id`
                FROM `products`
                LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
                LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
                WHERE `product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` =''
                GROUP BY `product_id`
                ORDER BY `product_id` DESC
        "; 
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function add($data) {
        $query =" INSERT INTO `products`(`product_art`,`product_name`,`product_description`,`product_price`,`product_quantity`,
        `product_img_link`, `product_manufacturer_id`)
        VALUES ('$data[product_art]',
        '$data[product_name]',
        '$data[product_description]',
        $data[product_price],
        $data[product_quantity],
        '$data[product_img_link]',
        $data[product_manufacturer_id]
        )
        ";
        return mysqli_query($this->connect,$query);
        // $productId = mysqli_insert_id($this->connect);

    }

    public function getById($id) {
        $query = "SELECT 
         `product_id`,`product_art`,`product_name`,`product_description`,`product_price`,`product_quantity`,
        `product_img_link`, `product_manufacturer_id` AS `manufacturers_getById`
        FROM `products` WHERE   `product_id` = $id;
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result);
    }

    public function getByNameTranslit($group_name_translit, $limit, $offset) {

    $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
        `product_img_link`, `warehouse_name`, `manufacturer_name`, `manufacturer_id`, `group_translit`, `group_name`
        FROM `products`
        LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
        LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
        LEFT JOIN `groups` ON `group_id` = `product_group_id`
        WHERE (`product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` ='') AND `group_translit` = '$group_name_translit'
        GROUP BY `product_id`
        ORDER BY `product_id` ASC
        LIMIT $offset, $limit";
        

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

    public function getTotal() {
        $query = "SELECT count(*) AS `count`
                    FROM `products` 
                    WHERE `product_is_deleted` = 0;
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];

    }

    public function getTotalGroup($group_name_translit) {
        $query = "SELECT count(*) AS `count`
                    FROM `products`
                    LEFT JOIN `groups` ON `group_id` = `product_group_id`
                    WHERE `product_is_deleted` = 0 AND `group_translit` = '$group_name_translit';
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];

    }
    

    public function edit($data, $id) {
        $query = 
            "UPDATE `products` 
            SET `product_art` = '$data[product_art]',
                `product_name` = '$data[product_name]',
                `product_description` = '$data[product_description]',
                `product_price` = $data[product_price],
                `product_quantity` = $data[product_quantity],
                `product_img_link` = '$data[product_img_link]',
                `product_manufacturer_id` = $data[product_manufacturer_id]
            WHERE `product_id` = $id";

        return mysqli_query($this->connect, $query);
        

    }

// // ожидает 2 массива
    public function dataDif( array $data, array $product) {
        $arr = array_diff($data, $product);
        $f = count($arr);
        if ($f == 1) {

            // if (empty(array_diff($data, $product))) {
                // var_dump(array_diff($data, $product)); 
            return 1;
            
        }else{
            'Ничего не изменилось';
        }; 
    }
    

    public function remove($id) {
        $query = 
        "UPDATE `products` 
        SET `product_is_deleted` = 1
        WHERE `product_id` = $id";
    return mysqli_query($this->connect, $query);
    }



    public function getProductByGroup($group_id) {
        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
                    `product_img_link`, `warehouse_name`, `manufacturer_name`, `manufacturer_id`
                FROM `products`
                LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
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