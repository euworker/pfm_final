<?php 

class Menu {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }

    public function getOneLevelNameGroups() {
        $query = "SELECT *
                    FROM `groups` 
                    WHERE `group_level` = '1'
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}