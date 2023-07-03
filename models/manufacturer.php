<?php

    class Manufacturer {

        
        private $connect;
        

        public function __construct(){

            $this->connect = DB::getConnection();

        }


        public function getAll() {
            $query = "SELECT * FROM `manufacturers` 
                        WHERE `manufacturer_is_deleted` = 0
                        ";
            $result = mysqli_query( $this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getAllPaginated($limit, $offset) {
            $query = "SELECT * FROM `manufacturers` 
                        WHERE `manufacturer_is_deleted` = 0
                        LIMIT $offset, $limit
                        ";
            $result = mysqli_query( $this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }


        public function insert($manufacturerName, $manufacturerDesc){
            $query = "INSERT INTO `manufacturers` (`manufacturer_name`, `manufacturer_description`) 
                        VALUES ('$manufacturerName', '$manufacturerDesc' )
                        ";
            return mysqli_query( $this->connect, $query);

        }      
        
        public function getById($id) {
            $query = "SELECT * FROM `manufacturers` 
                        WHERE `manufacturer_id` = $id
                        ";
            $manufactuer = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($manufactuer);

        }

        public function edit($manufacturerName, $manufacturerDesc, $id) {
            $query = 
                "UPDATE `manufacturers` 
                    SET `manufacturer_name` = '$manufacturerName',
                    `manufacturer_description` = '$manufacturerDesc'
                    WHERE `manufacturer_id` = $id
                    ";
            return mysqli_query($this->connect, $query);
            

        }

        public function remove($id) {
            $query = 
            "UPDATE `manufacturers` 
                SET `manufacturer_is_deleted` = 1
                WHERE `manufacturer_id` = $id
                ";
        return mysqli_query($this->connect, $query);
        }

        public function getTotal() {
            $query = "SELECT count(*) AS `count`
                        FROM `manufacturers` 
                        WHERE `manufacturer_is_deleted` = 0
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];

        }

    }

?>