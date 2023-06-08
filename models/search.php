
<?php 


//  сделать через куки
class Search {

    private $connect;
        

    public function __construct(){

        $this->connect = DB::getConnection();

    }



    public function getSearchResult($search) {
        $query = "SELECT *, group_translit
                    FROM `products`
                    LEFT JOIN groups 
                    ON `product_group_id` = `group_id`
                    WHERE MATCH (`product_art`) 
                    AGAINST ('$search') 
                    OR MATCH (`product_name`) 
                    AGAINST ('$search')
                    LIMIT 20;
        ";
        $result = mysqli_query($this->connect, $query);    
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }



    
}


