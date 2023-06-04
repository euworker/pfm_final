<?php 

class Group {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }


    public function getGroupsCount() {
        $query = "SELECT count(*) AS `count`
                    FROM `groups` 
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_assoc($result)['count'];
    }

    public function getNameGroups() {
        $query = "SELECT *
                    FROM `groups` 
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function getOneLevelNameGroups() {
        $query = "SELECT *
                    FROM `groups` 
                    WHERE `group_level` = '1'
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    public function getAllGroupsPaginated($limit, $offset) {
        $query = "SELECT * FROM `groups` 
                    LIMIT $offset, $limit
                    ";
        $result = mysqli_query( $this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

}