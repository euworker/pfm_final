<?php 

class Main {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getManufacturersTotal() {
        $query = "SELECT count(*) AS `count`
                    FROM `manufacturers` 
                    WHERE `manufacturer_is_deleted` = 0
                    LIMIT 6;
                    ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];

    }
    public function getAllManufacturersPaginated($limit, $offset) {
        $query = "SELECT * FROM `manufacturers` 
                    WHERE `manufacturer_is_deleted` = 0
                    LIMIT $offset, $limit
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    public function getMainGroups() {
        $query = "SELECT * FROM `groups` 
                    WHERE group_level = 1 
                    LIMIT 6
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }

    public function getMenuGroups() {
        $query = "SELECT * FROM `groups` 
                    WHERE group_level = 1 
                    LIMIT 6
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }




}