<?php 

class Product {


    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getAll() {

        
        $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
                    `product_img_link`, `manufacturer_name`, `manufacturer_id`
                    -- `warehouse_name`
                FROM `products`
                -- LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
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

    public function getProductsByNameTranslitGroup($group_name_translit, $limit, $offset) {
    $query = " SELECT `parent_group_id`
        FROM `groups`
        LEFT JOIN `groups_tree` ON `group_id` = `children_group_id`
        WHERE `group_translit` = '$group_name_translit'
        ";
    $result = mysqli_query($this->connect, $query);
    $parent_group_id = mysqli_fetch_assoc($result)['parent_group_id'];

    $query ="SELECT `product_id`, `product_art`, `product_name`, `product_description`, `product_price`, `product_quantity`, 
        `product_img_link`, `manufacturer_name`, `manufacturer_id`, `group_translit`, `group_name`, 
        (SELECT `group_translit`
                FROM `groups` 
                WHERE `group_id` = '$parent_group_id') as `parent_group_name`
        -- `warehouse_name`,
        FROM `products`
        -- LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
        LEFT JOIN `manufacturers` ON `product_manufacturer_id` = `manufacturer_id`
        LEFT JOIN `groups` ON `group_id` = `product_group_id`
        WHERE (`product_is_deleted` = 0 OR `product_is_deleted` is null OR `product_is_deleted` ='') AND `group_translit` = '$group_name_translit'
        GROUP BY `product_id`
        ORDER BY `product_id` ASC
        LIMIT $offset, $limit";
        

       $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getGroupByNameTranslitGroup($group_name_translit, $limit, $offset) {
       
       $query = " SELECT `group_id`
            FROM `groups`
            LEFT JOIN `groups_tree` ON `group_id` = `children_group_id`
            WHERE `group_translit` = '$group_name_translit'
            ";
        $result = mysqli_query($this->connect, $query);
        $parent_group_id = mysqli_fetch_assoc($result)['group_id'];

        $query ="SELECT `group_id`, `group_name`, `group_translit`, `group_level`, `main_group_id`, `parent_group_id`, `children_group_id`, 
            (SELECT `group_name`
                FROM `groups` 
                WHERE `group_translit` = '$group_name_translit') as `parent_group_name`
            FROM `groups`
            LEFT JOIN `groups_tree` ON `group_id` = `children_group_id`
            WHERE parent_group_id = '$parent_group_id' 
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


    public function getGroupLevel($group_name_translit) {
        $query = "SELECT group_level 
                    FROM `groups` 
                    WHERE `group_translit` = '$group_name_translit';
        ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['group_level'];
    }

    // public function getGroupParent($group_name_translit) {
    //     $query = "SELECT `group_name`
    //                 FROM `groups` 
    //                 WHERE `group_translit` = '$group_name_translit';
    //     ";
    //     $result = mysqli_query($this->connect, $query);
    //     return mysqli_fetch_assoc($result)['group_name'];
    // }



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
            LEFT JOIN `groups_tree` ON `group_id` = `children_group_id`
            WHERE `group_translit` = '$group_name_translit'
            ";
        $result = mysqli_query($this->connect, $query);
        $parent_group_id = mysqli_fetch_assoc($result)['group_id'];

    $query = "SELECT count(*) AS `count`
                    FROM `groups`
                    LEFT JOIN `groups_tree` ON `group_id` = `children_group_id`
                    WHERE `parent_group_id` = '$parent_group_id'
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
                    `product_img_link`, `manufacturer_name`, `manufacturer_id`
                    -- `warehouse_name`,
                FROM `products`
                -- LEFT JOIN `warehouses` ON `product_warehouse_id` = `warehouse_id`
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